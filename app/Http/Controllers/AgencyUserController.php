<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\AgencyCommission;
use App\Models\AgencyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AgencyUserController extends Controller
{

    public function index()
    {
        $agencyUsers = Agency::with('users', 'commission')->get();

        return view('agency_users.index', compact('agencyUsers'));
    }

    public function create()
    {
        $agencies =  Agency::all();

        return view('agency_users.create', compact('agencies'));


    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|unique:agency_users',
            'password' => 'required',
            'email' => 'required|unique:agency_users',
            'discount_rate' => 'required|numeric',
            'agency_id' => 'required|exists:agencies,id',
            'agency_level' => 'required|integer|min:1',
        ]);


        $uuid = Str::uuid();

        $agencyUser = new AgencyUser();
        $agencyUser->id = $uuid;
        $agencyUser->username = $request->input('username');
        $agencyUser->password = bcrypt($request->input('password'));
        $agencyUser->email = $request->input('email');
        $agencyUser->agency_id = $request->input('agency_id');
        $agencyUser->agency_level = $request->input('agency_level');
        $agencyUser->save();

        $commission = new AgencyCommission();
        $commission->agency_id = $request->input('agency_id');
        $commission->commission_rate = $request->input('discount_rate');
        $commission->save();

        return redirect()->route('agency.create')->with('success', 'Tạo tài khoản đại lý thành công.');
    }
}
