<?php

namespace App\Listeners;

use App\Models\AdminUser;
use App\Models\AgencyProfit;
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
     * @param  OrderSuccess  $event
     * @return void
     */
    public function handle(OrderSuccess $event)
    {
        $order = $event->order;
        $totalPrice = $event->order->total;
        $agencyId = Session::get('agency_id');
        $agency = AdminUser::find($agencyId);
        $commission =  $totalPrice * ($agency->commission_rate / 100);

        // Lưu lợi nhuận vào bảng agency_profits
        AgencyProfit::updateOrCreate(
            ['agency_id' => $agencyId],
            ['total_profit' => DB::raw("total_profit + $commission"), 'last_updated_at' => now()]
        );

//        Log::info('Commission for agency ' . $agencyId . ' is: ' . $commission);
    }
}
