@extends($templatePathAdmin.'layout')

@section('main')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-capitalize text-center">danh sách đại lý</h3>
                <a class="btn btn-success text-capitalize" href="{{ route('agency_users.create') }}">tạo mới đại lý</a>

            </div>
        </div>
    </div>
@endsection