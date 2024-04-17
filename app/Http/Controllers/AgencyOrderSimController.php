<?php

namespace App\Http\Controllers;

use App\Models\AgencyOrderSim;
use Illuminate\Http\Request;

class AgencyOrderSimController extends Controller
{
    public function index()
    {
        $userData = session('agency_user');
        $agencyId = $userData['id'];
        $agencyUser = session('agency_user');
        if ($agencyUser && $agencyUser->agency_level != 1) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        $transaction = AgencyOrderSim::query()
            ->where('agency_user_id', $agencyId)
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('agency_order_sim.index', compact('transaction'));
    }

    public function createOrderSim(Request $request)
    {
        return view('agency_order_sim.create');
    }

    public function processCreateOrderSim(Request $request)
    {

        $request->validate([
            'sim_type' => 'required|in:sim_thuong,esim',
            'quantity' => 'required|integer|min:1',
            'delivery_address' => 'required|string',
            'contact_email' => 'required|email',
            'phone' => 'required|string',
        ]);
        $userData = session('agency_user');
        if ($userData) {
            $agencyId = $userData['id'];
        }
        $order = new AgencyOrderSim();
        $order->agency_user_id = $agencyId;
        $order->sim_type = $request->input('sim_type');
        $order->quantity = $request->input('quantity');
        $order->delivery_address = $request->input('delivery_address');
        $order->contact_email = $request->input('contact_email');
        $order->phone = $request->input('phone');

        $order->save();

        return redirect()->route('agency_user.list_order_sim')->with('create_order_success', 'tạo đơn hàng thành công');
    }


    public function editInfoOrderSim($id)
    {
        $userData = session('agency_user');
        $agencyId = $userData['id'];

        $transaction = AgencyOrderSim::query()
            ->where('agency_user_id', $agencyId)->first();

        return view('agency_order_sim.edit', compact('transaction'));
    }

    public function processEditInfoOrderSim(Request $request, $id)
    {
        $request->validate([
            'sim_type' => 'required|in:sim_thuong,esim',
            'quantity' => 'required|integer|min:1',
            'delivery_address' => 'required|string',
            'contact_email' => 'required|email',
            'phone' => 'required|string',
        ]);

        $infoOrder = AgencyOrderSim::query()->findOrFail($id);
        $infoOrder->sim_type = $request->input('sim_type');
        $infoOrder->quantity = $request->input('quantity');
        $infoOrder->delivery_address = $request->input('delivery_address');
        $infoOrder->contact_email = $request->input('contact_email');
        $infoOrder->phone = $request->input('phone');

        $infoOrder->save();

        return redirect()->route('agency_user.list_order_sim')->with('update_order_success', 'cập nhật đơn hàng thành công');
    }
}
