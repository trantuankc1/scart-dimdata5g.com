<?php
/**
 * Controller Plugin payment Momo basic
 * User for Momo api v1.0
 *
 * @package    App\Plugins\Payment\MomoBasic\Controllers
 * @subpackage FrontController
 * @copyright  Copyright (c) 2020 SCart opensource.
 * @author     Lanh le <lanhktc@gmail.com>
 */

#App\Plugins\Payment\MomoBasic\Controllers\FrontController.php
namespace App\Plugins\Payment\MomoBasic\Controllers;

use App\Plugins\Payment\MomoBasic\AppConfig;
use SCart\Core\Front\Controllers\RootFrontController;
use SCart\Core\Front\Models\ShopOrder;
use SCart\Core\Front\Controllers\ShopCartController;
class FrontController extends RootFrontController
{
    public $plugin;

    public function __construct()
    {
        parent::__construct();
        $this->plugin = new AppConfig;
    }

    /**
     * Process order
     *
     * @return  [redirect] 
     */
    public function processOrder(){

        $dataOrder = session('dataOrder')?? [];
        $currency = $dataOrder['currency'] ?? '';

        //Validate currency
        if(!in_array($currency, $this->plugin->currencyAllow)) {
            $msg = sc_language_render($this->plugin->pathPlugin.'::lang.currency_only_allow', ['list' => implode(',', $this->plugin->currencyAllow)]);
            return redirect(sc_route('cart'))->with(['error' => $msg]);
        }
        //Validate order id exist
        if (session('orderID')) {
            return redirect(sc_route('momobasic.index'));
        } else {
            return redirect(sc_route('cart'))->with(['error' => sc_language_render($this->plugin->pathPlugin.'::lang.order_not_found')]);
        }
    }

    public function index() {
        //get sesstion data
        $dataOrder = session('dataOrder');
        $orderID = session('orderID');

        if(!$orderID) {
            return redirect(sc_route('cart'))->with(['error' => sc_language_render(sc_language_render($this->plugin->pathPlugin.'::lang.order_not_found'))]);
        }

        //Config info  create new capture
        $orderData = [
            'id' => (string)$orderID, //string
            'amount' => (string)$dataOrder['total'], //string
        ];

        $configData = [
            'returnUrl' => sc_route('momobasic.process'), //return  redirect after momo process
            'notifyUrl' => sc_route('momobasic.ipn'),//use for IPN
            'email' => sc_store('email'), //email alert
        ];
        //create new capture
        $dataResponse =  $this->plugin->payment->createCaptureMoMoRequest($orderData, $configData);

        if($dataResponse['errorCode'] == 0) {

            // Check order id response
            if($orderID != $dataResponse['orderId']) {
                $msg = sc_language_render($this->plugin->pathPlugin.'::lang.data_response_not_match', ['field' => 'orderId']);
                return redirect(sc_route('cart'))->with(['error' => $msg]);
            }

            // Check data response
            $scKey = $this->plugin->payment->getSecretKey();
            $stringResponse = "requestId=".$dataResponse['requestId']."&orderId=".$dataResponse['orderId']
            ."&message=".($dataResponse['message']??null)."&localMessage=".($dataResponse['localMessage']??null)
            ."&payUrl=".($dataResponse['payUrl'] ??null)."&errorCode=".($dataResponse['errorCode']??null)
            ."&requestType=".($dataResponse['requestType']??null);      
            $signature = hash_hmac("sha256", $stringResponse, $scKey);
            if($signature != $dataResponse['signature']) {
                $msg = sc_language_render($this->plugin->pathPlugin.'::lang.data_response_not_match', ['field' => 'Signature']);
                (new ShopOrder)->updateStatus($orderID, sc_config('momo_order_status_faild', 6), $msg);
                return redirect(sc_route('cart'))->with(['error' => $msg]);
            }
            return redirect($dataResponse['payUrl']);
        } else {
            $msg = $dataResponse['message'].json_encode($dataResponse['details']??[]);
            (new ShopOrder)->updateStatus($orderID, sc_config('momo_order_status_faild', 6), $msg);
            return redirect(sc_route('cart'))->with(['error' => $msg]);
        }
    }

    /**
     * Process order info response in page redirect
     */
    public function processResponse() {
        $customer = session('customer');
        $orderID = session('orderID');
        $dataResponse = request()->all();

        // Check order id response
        if($orderID !== $dataResponse['orderId']) {
            $msg = sc_language_render($this->plugin->pathPlugin.'::lang.data_response_not_match', ['field' => 'orderId']);
            return redirect(sc_route('cart'))->with(['error' => $msg]);
        }

        if($dataResponse['errorCode'] == 0 && $dataResponse['transId']) {
            // Check data response
            $scKey = $this->plugin->payment->getSecretKey();
            $stringResponse = "partnerCode=".$dataResponse['partnerCode']."&accessKey=".$dataResponse['accessKey']
            ."&requestId=".($dataResponse['requestId']??null)."&amount=".($dataResponse['amount']??null)
            ."&orderId=".($dataResponse['orderId'] ??null)."&orderInfo=".($dataResponse['orderInfo']??null)
            ."&orderType=".($dataResponse['orderType']??null)."&transId=".($dataResponse['transId']??null)
            ."&message=".($dataResponse['message']??null)."&localMessage=".($dataResponse['localMessage']??null)
            ."&responseTime=".($dataResponse['responseTime']??null)."&errorCode=".($dataResponse['errorCode']??null)
            ."&payType=".($dataResponse['payType']??null)."&extraData=".($dataResponse['extraData']??null)
            ;     
            $signature = hash_hmac("sha256", $stringResponse, $scKey);
            if($signature != $dataResponse['signature']) {
                //Update status order here
                $msg = sc_language_render($this->plugin->pathPlugin.'::lang.data_response_not_match', ['field' => 'Signature']);
                (new ShopOrder)->updateStatus($orderID, sc_config('momo_order_status_faild', 6), $msg);
                return redirect(sc_route('cart'))->with(['error' => $msg]);
            } else {
                ShopOrder::find($orderID)->update([
                    'transaction' => $dataResponse['transId'], 
                    'status' => sc_config('momo_order_status_success', 2),
                    'payment_status' => sc_config('momo_payment_status', 3)
                    ]);

                //Add history
                $dataHistory = [
                    'order_id' => $orderID,
                    'content' => 'Transaction ' . $dataResponse['transId'],
                    'customer_id' => $customer->id ?? 0,
                    'order_status_id' => sc_config('momo_order_status_success', 2),
                ];
                (new ShopOrder)->addOrderHistory($dataHistory);
                //Complete order
                return (new ShopCartController)->completeOrder();
            }
        } else{
            //Add history
            $msg = $dataResponse['message'].json_encode($dataResponse['details']??[]);
            $dataHistory = [
                'order_id' => $orderID,
                'content' => $msg,
                'customer_id' => $customer->id ?? 0,
                'order_status_id' => sc_config('momo_order_status_success', 2),
            ];
            (new ShopOrder)->addOrderHistory($dataHistory);
            return redirect(sc_route('cart'))->with(['error' => $msg]);
        }
    }

    /**
     * Process IPN
     */
    public function processIpn()
    {
        //
    }


}
