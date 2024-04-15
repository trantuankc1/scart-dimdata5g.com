<?php

namespace App\Http\Controllers;

use App\Models\AgencyEarning;
use App\Models\AgencyWithdrawalRequest;
use Illuminate\Http\Request;

class AgencyWithdrawalController extends Controller
{

    public function getAgecyEarning()
    {
        $userData = session('agency_user');
        if ($userData) {
            $agencyId = $userData['id'];
            $resultAgencyEarning = AgencyEarning::query()->where('agency_user_id', $agencyId)->first();
        }

        return $resultAgencyEarning;
    }

    public function index()
    {
        $agencyUserEarning = $this->getAgecyEarning();
        $infoId = $this->getAgecyEarning()->agency_user_id;
        if ($infoId) {
            $transaction = AgencyWithdrawalRequest::query()->where('agency_user_id', $infoId)->orderBy('id', 'desc')->paginate(15);
        } else {
            $transaction = null;
        }

        return view('dashboard_agency.payout', compact('agencyUserEarning', 'transaction'));
    }


    public function processWithdraw(Request $request)
    {
        $infoId = $this->getAgecyEarning()->agency_user_id;
        $request->validate([
            'bank_name' => 'required|string',
            'bank_account_number' => 'required|string',
            'amount' => 'required|numeric|min:1',
        ]);

        // Lấy thông tin số dư của đại lý
        $agencyUserEarning = AgencyEarning::where('agency_user_id', $infoId)->first();
        $totalProfit = $agencyUserEarning->total_profit;

        // Kiểm tra xem số tiền rút có lớn hơn số dư không
        if ($request->amount > $totalProfit) {
            return redirect()->back()->with('error', 'Số tiền rút không được lớn hơn số dư trong tài khoản của bạn.');
        }

        // Tạo yêu cầu rút tiền mới
        $withdrawalRequest = new AgencyWithdrawalRequest();
        $withdrawalRequest->agency_user_id = $infoId;
        $withdrawalRequest->bank_name = $request->input('bank_name');
        $withdrawalRequest->name_account_owner = $request->input('name_account_owner');
        $withdrawalRequest->bank_account_number = $request->input('bank_account_number');
        $withdrawalRequest->amount = $request->input('amount');

        $withdrawalRequest->save();

        // Cập nhật số dư trong bảng agency_earnings
        $agencyUserEarning->total_profit -= $request->input('amount');
        $agencyUserEarning->save();

        return redirect()->back()->with('success', 'Yêu cầu rút tiền của bạn đã được gửi thành công.');
    }


    public function editInfoPayout($id)
    {
        $transaction = AgencyWithdrawalRequest::query()->where('id', $id)->first();

        return view('dashboard_agency.edit_info_bank', compact('transaction'));
    }

    public function updateInfoBank(Request $request, $id)
    {
        $request->validate([
            'bank_name' => 'required|string',
            'bank_account_number' => 'required|numeric',
            'name_account_owner' => 'required|string',
        ]);

        $transaction = AgencyWithdrawalRequest::findOrFail($id);
        $transaction->bank_name = $request->bank_name;
        $transaction->bank_account_number = $request->bank_account_number;
        $transaction->name_account_owner = $request->name_account_owner;
        $transaction->save();

        return redirect()->route('agency_user.dashboard')->with('success', 'Thông tin ngân hàng đã được cập nhật thành công.');
    }

}
