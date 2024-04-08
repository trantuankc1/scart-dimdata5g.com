@extends($templatePathAdmin.'layout')

@section('main')
    <div class="container">
        <h2 class="text-capitalize text-center">cấp Đại Lý</h2>
        <a class="btn btn-success text-capitalize" href="{{ route('agency.create') }}">tạo cấp đại lý</a>

    </div>
@endsection