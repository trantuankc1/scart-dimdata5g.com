@extends($templatePathAdmin.'layout')

@section('main')
    <div class="container card" style="padding-bottom: 10px">
        <h3 class="text-capitalize">sửa đại lý</h3>
        <form class="mt-4" method="post" action="{{ route('agencies.update', $agency->id) }}">
            @csrf
            @method('PUT')
            <div class="input-group input-group-lg">
                <span class="input-group-text text-capitalize" id="inputGroup-sizing-lg">tên đại lý</span>
                <input type="text" name="name" class="form-control" aria-label="Sizing example input"
                       aria-describedby="inputGroup-sizing-lg" value="{{ $agency->name }}">
            </div>
            <button class="btn btn-success mt-2 text-capitalize" type="submit" style="width: 10%">gửi</button>
        </form>
    </div>
@endsection