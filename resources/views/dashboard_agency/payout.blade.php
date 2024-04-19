@extends('dashboard_agency.layout.app')
@section('content')
    <div class="container text-center page-breadcrumb text-capitalize card">
        <h3>yêu cầu rút tiền</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="col box-total-money-by-month box-total">
                    <p class="fw-bold"><i class="mdi mdi-cash"></i> số dư được rút</p>
                    <p>{{ number_format(optional($agencyUserEarning)->total_profit ?? 0) }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="col box-total-money-by-month">
                    <form id="withdrawForm" action="{{ route('agency_user.process_withdraw') }}" method="POST">
                        @csrf
                        @method('POST')
                        <select class="form-select text-capitalize" aria-label="Default select example" name="bank_name" required>
                            <option disabled selected value="">Chọn ngân hàng</option>
                            <option value="vietcombank">Vietcombank</option>
                            <option value="techcombank">Techcombank</option>
                            <option value="mbbank">MB Bank</option>
                            <option value="acb">ACB Bank</option>
                        </select>
                        <div class="input-group mt-3">
                            <input type="number" name="bank_account_number" placeholder="nhập số tài khoản nhận tiền ở đây !" class="form-control" aria-label="Dollar amount (with dot and two decimal places)" required>
                        </div>
                        <div class="input-group mt-3">
                            <input type="text" name="name_account_owner" placeholder="nhập tên chủ tài khoản ở đây !" class="form-control" aria-label="Dollar amount (with dot and two decimal places)" required>
                        </div>

                        <div class="input-group mt-3">
                            <span class="input-group-text">$</span>
                            <input type="number" name="amount" placeholder="nhập số tiền cần rút ở đây" class="form-control" aria-label="Dollar amount (with dot and two decimal places)" required>
                        </div>
                        <button type="button" onclick="validateForm()" class="btn btn-success mt-2">Rút Tiền</button>
                    </form>
                </div>
                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        Số tiền rút không được lớn hơn số dư trong tài khoản của bạn.
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        Yêu cầu rút tiền của bạn đã được gửi thành công.
                    </div>
                @endif
            </div>
        </div>
        <div class="container mt-2">
            @if(isset($transaction) && !is_null($transaction))
            <table class="table table-hover table-bordered">
                <tr>
                    <td>STT</td>
                    <td>ID</td>
                    <td>ngân hàng</td>
                    <td>số tài khoản</td>
                    <td>chủ tài khoản</td>
                    <td>số tiền</td>
                    <td>trạng thái</td>
                    <td>thời gian đặt lệnh</td>
                </tr>
                <tbody>
                @php $stt = 1; @endphp
                @if(isset($transaction) && !is_null($transaction))

                    @foreach($transaction as $infoTransaction)
                    <tr>
                        <td>{{ $stt++ }}</td>
                        <td>{{ $infoTransaction->agency_user_id }}</td>
                        <td>{{ $infoTransaction->bank_name }}</td>
                        <td>{{ $infoTransaction->bank_account_number }}</td>
                        <td>{{ $infoTransaction->name_account_owner }}</td>
                        <td>{{ number_format($infoTransaction->amount) }} vnđ</td>
                        <td>{{ $infoTransaction->status }}</td>
                        <td>{{ $infoTransaction->created_at }}</td>
                        <td><a href="{{ route('agency_user.edit_info_bank', $infoTransaction->id) }}" class="btn btn-info">Sửa</a></td>
                    </tr>
                @endforeach
                @endif
                </tbody>
            </table>
            {{ $transaction->links('vendor.pagination.bootstrap-4') }}
            @endif
        </div>
    </div>
    <style>
        .box-total {
            background-color: white;
        }
    </style>
    <script>
        function validateForm() {
            var form = document.getElementById("withdrawForm");
            var bankName = form.bank_name.value;
            var bankAccountNumber = form.bank_account_number.value;
            var nameAccountOwner = form.name_account_owner.value;
            var amount = form.amount.value;

            if (bankName === "" || bankAccountNumber === "" || nameAccountOwner === "" || amount === "") {
                alert("Vui lòng nhập đầy đủ thông tin.");
                return false;
            }

            // Kiểm tra số tiền phải là số dương
            if (parseFloat(amount) <= 0) {
                alert("Số tiền phải lớn hơn 0.");
                return false;
            }

            // Thực hiện submit nếu thông tin đã hợp lệ
            form.submit();
        }
    </script>
@endsection

