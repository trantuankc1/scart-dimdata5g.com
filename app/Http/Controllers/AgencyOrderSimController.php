<?php

namespace App\Http\Controllers;

use App\Models\AgencyOrderSim;
use Illuminate\Http\Request;

class AgencyOrderSimController extends Controller
{
    public function index()
    {
        $transaction = AgencyOrderSim::query()->orderBy('id', 'desc')->paginate(15);

        return view('agency_order_sim.index', compact('transaction'));
    }

    public function createOrderSim(Request $request)
    {
        return view('agency_order_sim.create');
    }
}
