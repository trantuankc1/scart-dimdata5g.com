<?php

namespace App\Listeners;

use App\Plugins\Payment\VnpayBasic\AppConfig;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use SCart\Core\Front\Models\ShopOrder;
use SCart\Core\Front\Models\ShopOrderHistory;
use SePay\SePay\Events\SePayWebhookEvent;
use SePay\SePay\Models\SePayTransaction;

class SePayWebhookListener implements ShouldQueue
{
    use InteractsWithQueue;

    public $plugin;

    public function __construct()
    {
        $this->plugin = new AppConfig;
    }

    public function handle(SePayWebhookEvent $event)
    {
        $data = $event->data;
        $orderID = $data['orderID'] ?? session('orderID');

        try {
            // Cập nhật thông tin vào bảng sepay_transactions
            $sepayTransaction = new SePayTransaction();
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

            // Cập nhật trạng thái đơn hàng
            $order = ShopOrder::find($orderID);
            if ($order) {
                $order->transaction = $data['sepay_BankTranNo'];
                $order->status = 5; // Giả sử trạng thái đã thành công
                $order->payment_status = 3; // Giả sử trạng thái thanh toán đã thành công
                $order->save();

                // Thêm lịch sử đơn hàng
                $dataHistory = [
                    'order_id' => $orderID,
                    'content' => 'Transaction ' . $data['sepay_BankTranNo'] . ' processed successfully',
                    'customer_id' => $order->customer_id ?? 0,
                    'order_status_id' => 2, // Giả sử trạng thái đã thành công
                    'add_date' => now(),
                ];
                ShopOrderHistory::create($dataHistory);
            } else {
                Log::error('Order not found with ID: ' . $orderID);
            }
        } catch (\Exception $e) {
            Log::error('Error processing SePay webhook: ' . $e->getMessage());
        }
    }
}
