@extends('dashboard_agency.layout.app')
@section('content')

    <div class="container text-center page-breadcrumb mt-3 card">
        <h3>Đại lý đã tạo</h3>
        <a class="btn btn-info" href="{{ route('agency_child.create') }}" style="width: 20%">Tạo mới đại lý</a>
        <table class="table table-bordered table-hover mt-2">
            <tr class="text-capitalize">
                <td>#</td>
                <td>Tên đại lý</td>
                <td>Email</td>
                <td>Cấp đại lý</td>
                <td>Chiết khấu</td>
            </tr>
            <tbody>
            @php $stt = 1 @endphp
            @foreach($agencyChildren as $agencyChild)
                <tr>
                    <td>{{ $stt++ }}</td>
                    <td>{{ $agencyChild->username }}</td>
                    <td>{{ $agencyChild->email }}</td>
                    <td>{{ $agencyChild->agency_level }}</td>
                    <td>{{ $agencyChild->commission_rate }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
