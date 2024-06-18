<?php

namespace App\Plugins\Payment\Sepay\Controllers;

use App\Listeners\SePayWebhookListener;
use App\Plugins\Payment\Sepay\AppConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use SCart\Core\Front\Controllers\RootFrontController;
use SePay\SePay\Models\SePayTransaction;

class FrontController extends RootFrontController
{
    protected $plugin;

    public function __construct()
    {
        parent::__construct();
        $this->plugin = new AppConfig;
    }

    public function index(Request $request)
    {
        return view($this->plugin->pathPlugin . '::Front');
    }


    public function processResponse(Request $request)
    {
        try {
            $data = $request->all();
            $sepayTransaction = new SepayTransaction();
            $sepayTransaction->gateway = $data['gateway'];
            $sepayTransaction->transactionDate = $data['transactionDate'];
            $sepayTransaction->accountNumber = $data['accountNumber'];
            $sepayTransaction->subAccount = $data['subAccount'] ?? null;
            $sepayTransaction->code = $data['code'] ?? null;
            $sepayTransaction->content = $data['content'];
            $sepayTransaction->transferType = $data['transferType'];
            $sepayTransaction->description = $data['description'] ?? null;
            $sepayTransaction->transferAmount = $data['transferAmount'];
            $sepayTransaction->referenceCode = $data['referenceCode'] ?? null;
            $sepayTransaction->save();
            // Phát sự kiện SePayWebhookReceived với dữ liệu từ webhook
            event(new SePayWebhookListener($data));

            // Trả về phản hồi thành công
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error processing SePay webhook: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to process SePay webhook'], 500);
        }
    }


        function processOrder()
        {
            $dataOrder = session('dataOrder') ?? [];
            $orderID = session('orderID');
            if (empty($dataOrder)) {
                return redirect()->route('home')->with('error', 'No order data found.');
            }

            $amount = $dataOrder['total'];
            $acc = '0369197931';
            $bank = 'MB';
            $qrUrl = "https://qr.sepay.vn/img?acc={$acc}&bank={$bank}&amount={$amount}&des={$orderID}";

            return view('sepay.qr-sepay', compact('dataOrder', 'orderID', 'qrUrl'));
        }

        public
        function processForm()
        {
            // Xử lý form nếu cần thiết
        }
    }
