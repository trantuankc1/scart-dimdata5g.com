<!-- View -->
@extends($templatePathAdmin.'layout')

@section('main')
    <div class="container-fluid">
        <h3 class="text-center text-capitalize">thanh toán đại lý</h3>

        <table class="table table-hover table-bordered">
            <tr class="text-capitalize text-center">
                <td>#</td>
                <td>ID</td>
                <td>tên đại lý</td>
                <td>tên ngân hàng</td>
                <td>chủ tài khoản ngân hàng</td>
                <td>số tài khoản ngân hàng</td>
                <td>số tiền yêu cầu rút</td>
                <td>trạng thái</td>
                <td>thời gian tạo yêu cầu</td>
                <td>action</td>
            </tr>
            <tbody>
            @php
                $stt = 1;
            @endphp
            @foreach($bank_request as $request)
                <tr class="text-uppercase">
                    <td>{{ $stt++ }}</td>
                    <td>{{ $request->agency_user_id }}</td>
                    <td>{{ $request->agencyUser->username }}</td>
                    <td>{{ $request->bank_name }}</td>
                    <td>{{ $request->name_account_owner }}</td>
                    <td>{{ $request->bank_account_number }}</td>
                    <td>{{ number_format($request->amount) }} vnđ</td>
                    <td>{{ $request->status }}</td>
                    <td>{{ $request->created_at }}</td>
                    <td>
                        <form action="{{ route('admin.update_status_bank_request', $request->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-select" aria-label="Default select example">
                                <option value="new" {{ $request->status == 'new' ? 'selected' : '' }}>new</option>
                                <option value="processing" {{ $request->status == 'processing' ? 'selected' : '' }}>processing</option>
                                <option value="completed" {{ $request->status == 'completed' ? 'selected' : '' }}>completed</option>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm mt-2">Cập nhật</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $bank_request->links('vendor.pagination.bootstrap-4') }}
    </div>
@endsection
