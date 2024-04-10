<?php

namespace App\Http\Controllers;

use App\Models\AgencyUser;
use Illuminate\Http\Request;

class AgencyDashBoardController extends Controller
{

    public function index()
    {
        $agencyUsers = AgencyUser::query()->with(['agency', 'commissions'])->first();

        return view('dashboard_agency.home', compact('agencyUsers'));
    }
}
