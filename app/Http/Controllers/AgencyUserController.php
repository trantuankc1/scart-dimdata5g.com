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
        $agencyUsers = AgencyUser::query()->with(['agency', 'commissions'])->get();
//        dd($agencyUsers);
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
        $commission->agency_user_id = $uuid;
        $commission->commission_rate = $request->input('discount_rate');
        $commission->save();

        return redirect()->route('agency_users.index')->with('success', 'Tạo tài khoản đại lý thành công.');
    }

    public function edit($id)
    {
        $agencyUser = AgencyUser::findOrFail($id);
        $agencies = Agency::all();

        return view('agency_users.edit', compact('agencyUser', 'agencies'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'username' => 'required|unique:agency_users,username,'.$id,
            'password' => 'required',
            'email' => 'required|unique:agency_users,email,'.$id,
            'discount_rate' => 'required|numeric',
            'agency_id' => 'required|exists:agencies,id',
            'agency_level' => 'required|integer|min:1',
        ]);

        $agencyUser = AgencyUser::findOrFail($id);
        $agencyUser->username = $request->input('username');
        $agencyUser->password = bcrypt($request->input('password'));
        $agencyUser->email = $request->input('email');
        $agencyUser->agency_id = $request->input('agency_id');
        $agencyUser->agency_level = $request->input('agency_level');
        $agencyUser->save();

        $commission = AgencyCommission::where('agency_user_id', $id)->first();
        $commission->commission_rate = $request->input('discount_rate');
        $commission->save();

        return redirect()->route('agency_users.index')->with('success', 'Cập nhật thông tin đại lý thành công.');
    }


    public function delete($id)
    {
        $agencyUser = AgencyUser::findOrFail($id);
        $agencyUser->delete();

        return redirect()->route('agency_users.index')->with('success', 'Đã xóa đại lý thành công.');
    }
}
