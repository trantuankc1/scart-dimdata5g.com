@extends('dashboard_agency.layout.app')
@section('content')

    <div class="container text-center page-breadcrumb text-capitalize card">
        <h3>đại lý đã tạo</h3>
        <a class="btn btn-info" href="{{ route('agency_child.create') }}" style="width: 20%">tạo mới đại lý</a>
        <table class="table table-bordered table-hover mt-2">
            <tr class="text-capitalize">
                <td>id</td>
                <td>tên đại lý</td>
                <td>email</td>
                <td>cấp đại lý</td>
                <td>chiết khấu</td>
            </tr>
        </table>
    </div>
@endsection

