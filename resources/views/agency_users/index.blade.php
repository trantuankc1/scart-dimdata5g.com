@extends($templatePathAdmin.'layout')

@section('main')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-capitalize text-center">danh sách đại lý</h3>
                <a class="btn btn-success text-capitalize" href="{{ route('agency_users.create') }}">tạo mới đại lý</a>
                <table class="table table-bordered table-hover text-center text-capitalize mt-2">
                    <thead>
                    <tr>
                        <th>cấp đại lý</th>
                        <th>Chiết Khấu %</th>
                        <th>đại lý</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($agencyUsers as $agency)
                        <tr>
                            <td>{{ $agency->name }}</td>
                            <td>{{ optional($agency->commission)->commission_rate }}</td>
                            <td>
                                <ul>
                                    @foreach ($agency->users as $user)
                                        <li>{{ $user->username }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td><a class="btn btn-info" href="{{ route('agency_users.edit', $agency->id) }}">sửa</a></td>
                            <td><a href="#">xóa</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection