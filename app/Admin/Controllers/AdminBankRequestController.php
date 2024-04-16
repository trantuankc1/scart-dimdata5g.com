<?php
namespace App\Admin\Controllers;

use App\Models\AgencyWithdrawalRequest;
use Illuminate\Http\Request;
use SCart\Core\Front\Controllers\RootFrontController;

class AdminBankRequestController extends RootFrontController
{
    public function index()
    {
        $bank_request = AgencyWithdrawalRequest::with('agencyUser')->orderByDesc('id')->paginate(20);

        return view('admin_bank_payment.index', compact('bank_request'));
    }

    public function updateStatusBankRequest(Request $request, $id)
    {
        $bankRequest = AgencyWithdrawalRequest::query()->findOrFail($id);

        $bankRequest->status = $request->input('status');
        $bankRequest->update();

        return redirect()->back()->with('success', 'Trạng thái đã được cập nhật thành công.');

    }
}
