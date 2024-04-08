@extends($templatePathAdmin.'layout')

@section('main')
    <div class="container">
        <h3 class="text-capitalize">Tạo cấp đại lý</h3>
        <form class="#" method="post" action="{{ route('agency.store') }}">
            @csrf

            <div class="input-group input-group-lg">
                <span class="input-group-text text-capitalize" id="inputGroup-sizing-lg">mô tả</span>
                <input type="text" name="name" class="form-control" aria-label="Sizing example input"
                       aria-describedby="inputGroup-sizing-lg" value="">
            </div>
            <div class="form-group">
                <label for="level">Cấp độ đại lý:</label>
                <input type="number" name="level" id="level" class="form-control" value="1" required>
                <small class="text-muted">Nhập số nguyên dương</small>
            </div>

            <button class="btn btn-success mt-2 text-capitalize" type="submit">gửi</button>
        </form>
    </div>
@endsection