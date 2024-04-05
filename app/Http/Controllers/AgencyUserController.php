<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\AgencyCommission;
use App\Models\AgencyUser;
use Illuminate\Http\Request;

class AgencyUserController extends Controller
{

    public function index()
    {
        $agencyUsers = Agency::with('users', 'commission')->get();

        return view('agency_users.index', compact('agencyUsers'));
    }

    public function create()
    {
        $agencies = Agency::all();

        return view('agency_users.create', compact('agencies'));
    }

    public function store(Request $request)
    {
        $user_agency = new AgencyUser();
        $user_agency->username = $request->input('username_agency');
        $user_agency->password = bcrypt($request->input('password_user_agency'));
        $user_agency->email = $request->input('email_user_agency');
        $user_agency->agency_id = $request->input('agency_id');

        $user_agency->save();


        $commission = new AgencyCommission();
        $commission->commission_rate = $request->input('commission_rate');
        // Assign agency_id
        $commission->agency_id = $request->input('agency_id');
        $commission->save();

        return redirect()->route('agency_users.index')->with('success', 'Tạo tài khoản đại lý thành công!');
    }


    public function edit($id)
    {
        $user = AgencyUser::findOrFail($id);

        return view('agency_users.edit', compact('user'));
    }


    public function update(Request $request, $id)
    {
        $user = AgencyUser::findOrFail($id);

        // Thực hiện validation dữ liệu ở đây nếu cần

        $user->update($request->all());

        return redirect()->route('agency-users.index')->with('success', 'Thông tin người quản lý đã được cập nhật thành công!');
    }

}
