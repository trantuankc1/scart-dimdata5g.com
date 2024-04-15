<?php

namespace App\Http\Controllers;

use App\Models\AgencyEarning;
use App\Models\AgencyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AgencyDashBoardController extends Controller
{
    public function redirectPageFromAgency()
    {
        $userData = session('agency_user');
        if ($userData) {
            $agencyId = $userData['id'];
            Session::put('agency_user_id', $agencyId);
            return redirect()->route('product.all', ['agencyUuid' => $agencyId]);
        } else {
            return redirect('/');
        }
    }

    public function index()
    {
        $agencyUsers = AgencyUser::query()->with(['agency', 'commissions', 'earnings'])->first();
        $agencyUserEarning = $this->getAgecyEarning();

        return view('dashboard_agency.home', compact('agencyUsers', 'agencyUserEarning'));
    }

    public function getAgecyEarning()
    {
        $userData = session('agency_user');
        if ($userData) {
            $agencyId = $userData['id'];
            $resultAgencyEarning = AgencyEarning::query()->where('agency_user_id', $agencyId)->first();
        }

        return $resultAgencyEarning;
    }
}
