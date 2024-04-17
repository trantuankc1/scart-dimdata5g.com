@extends('dashboard_agency.layout.app')
@section('content')
    <div class="container card">
        <h2 class="text-capitalize text-center">danh sách lô sim đã tạo</h2>
        <a href="{{ route('agency_user.create_order_sim') }}" style="width: 20%" class="btn btn-info text-capitalize">tạo đơn hàng mới</a>
        @if(session('create_order_success'))
            <div class="alert alert-success" role="alert">
                tạo đơn hàng thành công
            </div>
        @endif

        @if(session('update_order_success'))
            <div class="alert alert-success" role="alert">
                cập nhật đơn hàng thành công
            </div>
        @endif
        <table class="table table-bordered table-hover mt-3 text-center">
            <tr class="text-capitalize">
                <td>#</td>
                <td>loại sim</td>
                <td>số lượng sim</td>
                <td>địa chỉ</td>
                <td>địa chỉ email</td>
                <td>số điện thoại</td>
                <td>trạng thái</td>
                <td>thời gian tạo đơn hàng</td>
            </tr>
            <tbody>
            @php
                $stt = 1;
            @endphp
            @foreach($transaction as $infoTransaction)
                <tr>
                    <td>{{ $stt++ }}</td>
                    <td>{{ $infoTransaction->sim_type }}</td>
                    <td>{{ $infoTransaction->quantity }}</td>
                    <td>{{ $infoTransaction->delivery_address }}</td>
                    <td>{{ $infoTransaction->contact_email }}</td>
                    <td>{{ $infoTransaction->phone }}</td>
                    <td>{{ $infoTransaction->status }}</td>
                    <td>{{ $infoTransaction->created_at }}</td>
                    <td><a href="{{ route('agency_user.edit_info_order_sim', $infoTransaction->id) }}"
                           class="btn btn-info">sửa</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
