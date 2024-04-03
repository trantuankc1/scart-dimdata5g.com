<?php
#App\Plugins\Payment\VnpayBasic\Controllers\FrontController.php
namespace App\Plugins\Payment\VnpayBasic\Controllers;

use App\Plugins\Payment\VnpayBasic\AppConfig;
use SCart\Core\Front\Models\ShopOrder;
use SCart\Core\Front\Controllers\ShopCartController;
use SCart\Core\Front\Controllers\RootFrontController;

class FrontController extends RootFrontController
{
    public $plugin;

    public function __construct()
    {
        parent::__construct();
        $this->plugin = new AppConfig;
    }

    public function index()
    {
        //
    }

    public function processOrder()
    {

        $dataOrder = session('dataOrder') ?? [];
        $currency = $dataOrder['currency'] ?? '';

        //Validate currency
        if (!in_array($currency, $this->plugin->currencyAllow)) {
            $msg = sc_language_render($this->plugin->pathPlugin . '::lang.currency_only_allow', ['list' => implode(',', $this->plugin->currencyAllow)]);
            return redirect(sc_route('cart'))->with(['error' => $msg]);
        }
        //Validate order id exist
        if (session('orderID')) {
            return $this->prepareDataBeforeSend();
        } else {
            return redirect(sc_route('cart'))
                ->with(['error' => sc_language_render('cart.order_not_found')]);
        }

    }

    /**
     * Process data before send to vnpay
     */
    public function prepareDataBeforeSend()
    {
        $vnp_Url = $this->plugin->urlApi;
        $vnp_HashSecret = $this->plugin->getSecretKey();
        $dataOrder = session('dataOrder') ?? [];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $this->plugin->getPartnerCode(),
            "vnp_Amount" => $dataOrder['total'] * 100, // require * 100
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'],
            "vnp_Locale" => 'vn',
            "vnp_OrderInfo" => 'simdata5g',
            "vnp_OrderType" => '1',
            "vnp_ReturnUrl" => sc_route('vnpay_basic.process'),
            "vnp_TxnRef" => session('orderID'),
        );
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
        , 'message' => 'success'
        , 'data' => $vnp_Url);
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }

        return redirect($vnp_Url);
    }

    /**
     * Process order info response in page redirect
     */
    public function processResponse()
    {
        $customer = session('customer');
        $orderID = session('orderID');

        // Kiểm tra order id response
        if (!$orderID) {
            $msg = sc_language_render($this->plugin->pathPlugin . '::lang.process_invalid');
            return redirect(sc_route('cart'))->with(['error' => $msg]);
        }

        $dataResponse = request()->all();

        // Kiểm tra mã lỗi phản hồi
        if ($dataResponse['vnp_ResponseCode'] === '24') {
            // Trường hợp hủy
            return redirect(sc_route('cart'));
        }

        // Kiểm tra mã lỗi
        if ($dataResponse['vnp_ResponseCode'] !== '00') {
            $msg = sc_language_render($this->plugin->pathPlugin . '::lang.error_number', ['code' => $dataResponse['vnp_ResponseCode']]);
            return redirect(sc_route('cart'))->with(['error' => $msg]);
        }

        // Kiểm tra phản hồi thành công
        if ($dataResponse['vnp_ResponseCode'] === '00') {
            // Tạo chuỗi hash từ dữ liệu phản hồi
            $secureHashData = '';
            foreach ($dataResponse as $key => $value) {
                if ($key !== 'vnp_SecureHash' && $key !== 'vnp_SecureHashType') {
                    $secureHashData .= '&' . $key . '=' . $value;
                }
            }

            // Tạo mã hash từ dữ liệu phản hồi và so sánh với vnp_SecureHash
            $vnpSecureHash = $dataResponse['vnp_SecureHash'];
            $vnp_HashSecret = $this->plugin->getSecretKey();

            $vnp_SecureHash = $_GET['vnp_SecureHash'];
            $inputData = array();
            foreach ($_GET as $key => $value) {
                if (substr($key, 0, 4) == "vnp_") {
                    $inputData[$key] = $value;
                }
            }

            unset($inputData['vnp_SecureHash']);
            ksort($inputData);
            $i = 0;
            $hashData = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
            }

            $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
            if ($secureHash == $vnp_SecureHash) {
                if ($_GET['vnp_ResponseCode'] == '00') {
                    echo "GD Thanh cong";
                }
                else {
                    echo "GD Khong thanh cong";
                }
            } else {
                echo "Chu ky khong hop le";
            }

            if ($secureHash !== $vnpSecureHash) {
                $msg = sc_language_render($this->plugin->pathPlugin . '::lang.process_invalid');
                return redirect(sc_route('cart'))->with(['error' => $msg]);
            }

            // Cập nhật trạng thái đơn hàng
            ShopOrder::find($orderID)->update([
                'transaction' => $dataResponse['vnp_BankTranNo'],
                'status' => sc_config('vnpay_order_status_success', 2),
                'payment_status' => sc_config('vnpay_payment_status', 3)
            ]);

            // Thêm lịch sử đơn hàng
            $dataHistory = [
                'order_id' => $orderID,
                'content' => 'Transaction ' . $dataResponse['vnp_BankTranNo'],
                'customer_id' => $customer->id ?? 0,
                'order_status_id' => sc_config('vnpay_order_status_success', 2),
            ];
            (new ShopOrder)->addOrderHistory($dataHistory);

            // Hoàn tất đơn hàng
            return (new ShopCartController)->completeOrder();
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