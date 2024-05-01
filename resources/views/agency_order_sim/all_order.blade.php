<!-- View -->
@extends('dashboard_agency.layout.app')

@section('content')
    <div class="container card">
        <h3 class="text-center text-capitalize">Đơn hàng hệ thống</h3>

        <table class="table table-hover table-bordered">
            <tr class="text-capitalize">
                <td>ID</td>
                <td>tổng</td>
                <td>tiền tệ</td>
                <td>tên</td>
                <td>họ</td>
                <td>địa chỉ 1</td>
                <td>địa chỉ 2</td>
                <td>quốc gia</td>
                <td>số điện thoại</td>
                <td>email</td>
                <td>phương thức thanh toán</td>
                <td>thời gian tạo</td>
            </tr>
            <tbody>
            @foreach($all_order as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->total }}</td>
                    <td>{{ $transaction->currency }}</td>
                    <td>{{ $transaction->first_name }}</td>
                    <td>{{ $transaction->last_name }}</td>
                    <td>{{ $transaction->address1 }}</td>
                    <td>{{ $transaction->address2 }}</td>
                    <td>{{ $transaction->country }}</td>
                    <td>{{ $transaction->phone }}</td>
                    <td>{{ $transaction->email }}</td>
                    <td>{{ $transaction->payment_method }}</td>
                    <td>{{ $transaction->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $all_order->links('vendor.pagination.bootstrap-4') }}
    </div>
@endsection
