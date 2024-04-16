<?php
namespace App\Admin\Controllers;

use App\Models\AgencyOrderSim;
use Illuminate\Http\Request;
use SCart\Core\Front\Controllers\RootFrontController;

class AdminListOrderSimController extends RootFrontController
{
    public function index()
    {
        $listOrderSim = AgencyOrderSim::with('agencyUser')->orderByDesc('id')->paginate(20);

        return view('admin_order_sim.index', compact('listOrderSim'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = AgencyOrderSim::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
}
