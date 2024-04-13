<?php

namespace App\Http\Controllers;

use App\Models\AgencyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AgencyDashBoardController extends Controller
{
    public function redirectPageFromAgency(Request $request, $agencyUuid)
    {
        $user = Auth::guard('agency_user')->user();
        if ($user) {
            $agencyUser = $user;
            Session::put('agency_user_id', $agencyUser->agency_id);
            return redirect()->route('product.all');
        } else {
            return redirect('/');
        }
    }

    public function index()
    {
        $agencyUsers = AgencyUser::query()->with(['agency', 'commissions'])->first();

        return view('dashboard_agency.home', compact('agencyUsers'));
    }
}
