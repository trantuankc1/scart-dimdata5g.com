<!-- View -->
@extends($templatePathAdmin.'layout')

@section('main')
    <div class="container-fluid">
        <h3 class="text-center text-capitalize">Đơn hàng đại lý</h3>

        <table class="table table-hover table-bordered">
            <tr class="text-capitalize">
                <td>#</td>
                <td>ID</td>
                <td>tên đại lý</td>
                <td>Loại sim</td>
                <td>Số lượng</td>
                <td>Địa chỉ</td>
                <td>Email</td>
                <td>Số điện thoại</td>
                <td>Trạng thái</td>
                <td>Thời gian tạo đơn</td>
                <td>Action</td> <!-- Thêm cột action -->
            </tr>
            <tbody>
            @php
                $stt = 1;
            @endphp
            @foreach($listOrderSim as $infoOrder)
                <tr>
                    <td>{{ $stt++ }}</td>
                    <td>{{ $infoOrder->agency_user_id }}</td>
                    <td>{{ $infoOrder->agencyUser->username }}</td>
                    <td>{{ $infoOrder->sim_type }}</td>
                    <td>{{ $infoOrder->quantity }}</td>
                    <td>{{ $infoOrder->delivery_address }}</td>
                    <td>{{ $infoOrder->contact_email }}</td>
                    <td>{{ $infoOrder->phone }}</td>
                    <td>{{ $infoOrder->status }}</td>
                    <td>{{ $infoOrder->created_at }}</td>
                    <td> <!-- Thêm form cập nhật trạng thái -->
                        <form action="{{ route('admin.process_update_status_order_sim', $infoOrder->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <select class="form-select" aria-label="Default select example" name="status">
                                <option value="new" {{ $infoOrder->status == 'new' ? 'selected' : '' }}>New</option>
                                <option value="processing" {{ $infoOrder->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ $infoOrder->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            <button type="submit" class="btn btn-success mt-2">cập nhật</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $listOrderSim->links('vendor.pagination.bootstrap-4') }}
    </div>
@endsection
