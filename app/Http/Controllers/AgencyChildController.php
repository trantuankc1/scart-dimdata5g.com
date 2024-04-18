<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\AgencyCommission;
use App\Models\AgencyRelation;
use App\Models\AgencyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AgencyChildController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userData = session('agency_user');
        $parentAgencyId = $userData['id'];

        $agencyChildren = AgencyRelation::where('parent_agency_id', $parentAgencyId)
            ->join('agency_users', 'agency_relations.child_agency_id', '=', 'agency_users.id')
            ->join('agency_commissions', 'agency_users.id', '=', 'agency_commissions.agency_user_id')
            ->select('agency_users.*', 'agency_commissions.commission_rate')
            ->get();


        return view('agency_child.index', compact('agencyChildren'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userData = session('agency_user');
        $parentAgencyId = $userData['id'];
        if ($userData['agency_level'] != 1) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        $parentAgencyCommission = AgencyCommission::where('agency_user_id', $parentAgencyId)->first();

        $agencyLevels = Agency::with('commissions')->where('level', '!=', 1)->get();

        return view('agency_child.create', compact('agencyLevels', 'parentAgencyId', 'parentAgencyCommission'));
    }



    /**
     * Store a newly created resource in storage.
     */
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
        $userData = session('agency_user');
        $parentAgencyId = $userData['id'];

        $uuid = Str::uuid();

        $agencyUser = new AgencyUser();
        $agencyUser->id = $uuid;
        $agencyUser->username = $request->input('username');
        $agencyUser->password = bcrypt($request->input('password'));
        $agencyUser->email = $request->input('email');
        $agencyUser->agency_id = $request->input('agency_id');
        $agencyUser->agency_level = $request->input('agency_level');
        $agencyUser->save();

        // Lưu thông tin mối quan hệ giữa đại lý cấp 1 và đại lý cấp 2 vào bảng agency_relationships
        $agencyRelationship = new AgencyRelation();
        $agencyRelationship->id = $uuid;
        $agencyRelationship->parent_agency_id = $parentAgencyId;
        $agencyRelationship->child_agency_id = $agencyUser->id; // Sử dụng UUID của đại lý cấp 2
        $agencyRelationship->save();

        // Tạo thông tin chiết khấu cho đại lý cấp 2
        $commission = new AgencyCommission();
        $commission->agency_id = $request->input('agency_id');
        $commission->agency_user_id = $agencyUser->id;
        $commission->commission_rate = $request->input('discount_rate');
        $commission->save();

        return redirect()->route('agency_child.index');
    }

    public function edit($id)
    {
        $agency = AgencyUser::query()->findOrFail($id);

        return view('agency_child.edit', compact('agency'));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
