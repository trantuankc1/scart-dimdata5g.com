<?php
#App\Plugins\Payment\SepayBasic\Controllers\FrontController.php
namespace App\Plugins\Payment\SepayBasic\Controllers;

use App\Plugins\Payment\SepayBasic\AppConfig;
use SCart\Core\Front\Models\ShopOrder;
use SCart\Core\Front\Controllers\ShopCartController;
use SCart\Core\Front\Controllers\RootFrontController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
class FrontController extends RootFrontController
{
    public $plugin;

    public function __construct()
    {
        parent::__construct();
        $this->plugin = new AppConfig;
    }

    public function index() {
        //
    }

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
            return redirect(sc_route('sepay.sepayqr'));//->with(['error' => $msg]);
            //return $this->prepareDataBeforeSend();
        } else {
           // die('38');
            return redirect(sc_route('cart'))
                ->with(['error' => sc_language_render('cart.order_not_found')]);
        }
        
    }
    
  function getSubstring($input) {
    // Tìm vị trí của chuỗi "BankAPINotify " trong input
    $startPos = strpos($input, "BankAPINotify ");
    if ($startPos === false) {
        return "Không tìm thấy chuỗi 'BankAPINotify'";
    }

    // Tính toán vị trí bắt đầu của chuỗi cần lấy
    $startPos += strlen("BankAPINotify ");

    // Lấy chuỗi còn lại sau "BankAPINotify "
    $remainingString = substr($input, $startPos);

    // Tìm vị trí của dấu chấm thứ ba
    $dotCount = 0;
    $dotPos = -1;
    while ($dotCount < 3) {
        $dotPos = strpos($remainingString, ".", $dotPos + 1);
        if ($dotPos === false) {
            break;
        }
        $dotCount++;
    }

    // Nếu tìm thấy đủ 3 dấu chấm
    if ($dotCount == 3) {
        // truong hop nay cho vcb
        // Tính toán vị trí bắt đầu của chuỗi cần lấy sau dấu chấm thứ ba
        $startPos = $dotPos + 1;

        // Tìm vị trí của từ bắt đầu bằng chữ 'S'
        $sPos = strpos($remainingString, "S", $startPos);
        if ($sPos === false) {
            return "Không tìm thấy chữ 'S' sau dấu chấm thứ ba";
        }

        // Lấy chuỗi từ vị trí dấu chấm thứ ba đến trước chữ 'S'
        $result = substr($remainingString, $startPos, $sPos - $startPos);
    } else {
        // bank khac
        // Nếu không đủ 3 dấu chấm, lấy 12 ký tự sau "BankAPINotify "
        $result = substr(str_replace(" ","",$remainingString), 0, 11);
    }

    return trim($result);
}
    
 public function extractCode($content) {
      // Sử dụng biểu thức chính quy để tìm chuỗi sau "BankAPINotify" cho đến khi gặp "FT", "Ma", "Mã" hoặc hết chuỗi
    preg_match('/BankAPINotify\s+(.+?)(?=\sFT|\sMa|\sMã|$)/', $content, $matches);
    // Trả về kết quả nếu tìm thấy, ngược lại trả về null
    return trim($matches[1]) ?? null;
}


    public function webhook(Request $request): Response{
       
         $dataResponse = request()->all();

        $orderID = $this->getSubstring( $dataResponse['description']);
       // dd($orderID);
       
     
        $order = ShopOrder::find($this->convertFormat(str_replace(" ","",$orderID)));
         
     // dd( $order);
        ShopOrder::find($this->convertFormat(str_replace(" ","",$orderID)))->update([
            'transaction' => $dataResponse['content'], 
            'status' => sc_config('sepay_order_status_success', 2),
            'payment_status' => sc_config('sepay_payment_status', 3)
            ]);
           // dd($orderID);

        //Add history
        $dataHistory = [
            'order_id' => $this->convertFormat($orderID),
            'content' => 'Transaction ' . $dataResponse['content'],
            'order_status_id' => sc_config('sepay_order_status_success', 2),
        ];
        (new ShopOrder)->addOrderHistory($dataHistory);
        (new ShopCartController)->completeOrder();
        Session::forget('orderID');
         //Session::forget('dataOrder');
        //Complete order
        // redirect(sc_route('order.success'));
        return response('ok');
    }

    public function checkorder(Request $request){
        $dataRequest = request()->all();
        $orderID = $dataRequest['orderId'];
       $order =  ShopOrder::find($orderID);
       
       $data = ['status' => $order['status']];
       return response()->json($data);
       // dd($order);
    }
    function convertFormat($input) {
        // Chia chuỗi thành các phần bằng cách sử dụng preg_match
        preg_match('/^(\w)(\w{5})(\w{5})$/', $input, $matches);
        
        // Kiểm tra xem có khớp với biểu thức chính quy không
        if ($matches) {
            // Ghép các phần lại với nhau bằng dấu "-"
            return $matches[1] . '-' . $matches[2] . '-' . $matches[3];
        }
        
        // Trả về chuỗi gốc nếu không khớp với biểu thức chính quy
        return $input;
    }
    public function sepayqr(){
        $dataOrder = session('dataOrder')?? [];
        $pathPlugin = $this->plugin->pathPlugin;
        // dd($dataOrder);
        $imgageUrl = 'https://qr.sepay.vn/img?' . http_build_query([
            'acc' => sc_config('so_tai_khoan'),
            'bank' => sc_config('ten_ngan_hang'),
            'amount' =>  $dataOrder['total'],
            'des' => session('orderID')."-".sc_config('tien_to_thanh_toan'),
            'template' => 'compact',
           
        ]);
        return view($pathPlugin.'::qr',
            [
                'title' => sc_language_render($pathPlugin.'::Lang.info'),
                'pathPlugin' => $pathPlugin,
                'imageUrl' => $imgageUrl,
                'orderId' => session('orderID'),
                'acc' => sc_config('so_tai_khoan'),
                'bank' => sc_config('ten_ngan_hang'),
                'chutaikhoan' => sc_config('chu_tai_khoan'),
                'amount' =>  $dataOrder['total'],
                'des' => session('orderID')."-".sc_config('tien_to_thanh_toan'),
                 'error' => ""
            ]
        );
    }

    /**
     * Process data before send to sepay
     */
    public function prepareDataBeforeSend() {
       
        $vnp_Url = $this->plugin->urlApi;
        $vnp_HashSecret = $this->plugin->getSecretKey();
        $dataOrder = session('dataOrder')?? [];
        $inputData = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => $this->plugin->getPartnerCode(),
            "vnp_Amount" => $dataOrder['total'] * 100, // require * 100
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'],
            "vnp_Locale" => 'vn',
            "vnp_OrderInfo" => 'Shop SCart',
            "vnp_OrderType" => '1',
            "vnp_ReturnUrl" => sc_route('sepay_basic.process'),
            "vnp_TxnRef" => session('orderID'),
        );
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        $vnp_Url = $vnp_Url . "?" . $query;
        $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
        $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        return redirect($vnp_Url);
    }

    /**
     * Process order info response in page redirect
     */
    public function processResponse() {
        $customer = session('customer');
        $orderID = session('orderID');
        // Check order id response
        if(!$orderID) {
            $msg = sc_language_render($this->plugin->pathPlugin.'::lang.process_invalid');
            return redirect(sc_route('cart'))->with(['error' => $msg]);
        }
        $dataResponse = request()->all();

        //Cancel
        if($dataResponse['vnp_ResponseCode'] === '24') {
            return redirect(sc_route('cart'));
        }
        //Error 
        if($dataResponse['vnp_ResponseCode'] !== '00') {
            $msg = sc_language_render($this->plugin->pathPlugin.'::lang.error_number', ['code' => $dataResponse['vnp_ResponseCode']]);
            return redirect(sc_route('cart'))->with(['error' => $msg]);
        }

        //Success
        if($dataResponse['vnp_ResponseCode'] === '00') {
            $vnpBankTranNo = $dataResponse['vnp_BankTranNo'];
            $vnpSecureHash = $dataResponse['vnp_SecureHash'];
            unset($dataResponse['vnp_SecureHashType']);
            unset($dataResponse['vnp_SecureHash']);
            ksort($dataResponse);
            $i = 0;
            $hashData = "";
            foreach ($dataResponse as $key => $value) {
                if ($i == 1) {
                    $hashData = $hashData . '&' . $key . "=" . $value;
                } else {
                    $hashData = $hashData . $key . "=" . $value;
                    $i = 1;
                }
            }
            //Compare vnpSecureHash
            $secureHash = hash('sha256',$this->plugin->getSecretKey() . $hashData);
            if($secureHash !== $vnpSecureHash) {
                $msg = sc_language_render($this->plugin->pathPlugin.'::lang.process_invalid');
                return redirect(sc_route('cart'))->with(['error' => $msg]);
            }

            ShopOrder::find($orderID)->update([
                'transaction' => $dataResponse['vnp_BankTranNo'], 
                'status' => sc_config('sepay_order_status_success', 2),
                'payment_status' => sc_config('sepay_payment_status', 3)
                ]);

            //Add history
            $dataHistory = [
                'order_id' => $orderID,
                'content' => 'Transaction ' . $vnpBankTranNo,
                'customer_id' => $customer->id ?? 0,
                'order_status_id' => sc_config('sepay_order_status_success', 2),
            ];
            (new ShopOrder)->addOrderHistory($dataHistory);
            //Complete order
            return redirect(sc_route('order.success'));
           // return (new ShopCartController)->completeOrder();

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
