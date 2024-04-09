<?php

namespace App\Listeners;

use App\Models\AdminUser;
use App\Models\AgencyCommission;
use App\Models\AgencyEarning;
use App\Models\AgencyProfit;
use App\Models\AgencyUser;
use AWS\CRT\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use SCart\Core\Events\OrderSuccess;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProcessOrderSuccess
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param OrderSuccess $event
     * @return void
     */
    public function handle(OrderSuccess $event)
    {
        $order = $event->order;
        $totalPrice = $order->total;
        $agencyUserId = Session::get('agency_user_id');

        // Tìm agency commission dựa trên agency_id
        $agencyCommission = AgencyCommission::where('agency_user_id', $agencyUserId)->first();

        if ($agencyCommission) {
            $commissionRate = $agencyCommission->commission_rate;
            $commission = $totalPrice * ($commissionRate / 100);

            // Lưu hoa hồng cho tài khoản đại lý cụ thể
            AgencyEarning::updateOrCreate(
                ['agency_user_id' => $agencyUserId],
                ['total_profit' => DB::raw("total_profit + $commission"), 'last_updated_at' => now()]
            );
        }
    }
}
