@extends('dashboard_agency.layout.app')
@section('content')
    <div class="container text-center page-breadcrumb text-capitalize">
        <h3>yêu cầu rút tiền</h3>
        <div class="container box-total-money-by-month">
            <form id="withdrawForm" action=" {{ route('agency_user.update_info_bank', $transaction->id) }}" method="POST">

                @csrf
                @method('PUT')
                <select class="form-select text-capitalize" aria-label="Default select example" name="bank_name"
                        required>
                    <option selected>chọn ngân hàng</option>
                    <option value="vietcombank">Vietcombank</option>
                    <option value="techcombank">Techcombank</option>
                    <option value="mbbank">MB Bank</option>
                    <option value="acb">ACB Bank</option>
                </select>
                <div class="input-group mt-3">
                    <input type="number" name="bank_account_number" placeholder="nhập số tài khoản nhận tiền ở đây !"
                           class="form-control" aria-label="Dollar amount (with dot and two decimal places)" required value="{{ $transaction->bank_account_number }}">
                </div>
                <div class="input-group mt-3">
                    <input type="text" name="name_account_owner" placeholder="nhập tên chủ tài khoản ở đây !"
                           class="form-control" aria-label="Dollar amount (with dot and two decimal places)" required value="{{ $transaction->name_account_owner }}">
                </div>
                <button type="submit" class="btn btn-info mt-2">cập nhật</button>
            </form>
        </div>
    </div>
@endsection

