@extends($templatePathAdmin.'layout')

@section('main')
    <div class="container">
        <h3 class="text-capitalize">Tạo mới đại lý</h3>
        <form class="#" method="post" action="{{ route('agency.store') }}">
            @csrf
            <div class="input-group input-group-lg">
                <span class="input-group-text text-capitalize" id="inputGroup-sizing-lg">tên đại lý</span>
                <input type="text" name="name" class="form-control" aria-label="Sizing example input"
                       aria-describedby="inputGroup-sizing-lg">
            </div>
            <button class="btn btn-success mt-2 text-capitalize" type="submit">gửi</button>
        </form>
    </div>
@endsection