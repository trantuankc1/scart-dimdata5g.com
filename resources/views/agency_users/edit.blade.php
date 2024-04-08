@extends($templatePathAdmin.'layout')

@section('main')
    <div class="container">
        <h3 class="text-capitalize text-center">Chỉnh sửa đại lý</h3>
        <form action="{{ route('agency_users.update', $agencyUser->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="input-group input-group-lg">
                <span class="input-group-text text-capitalize" id="inputGroup-sizing-lg">Tên đại lý</span>
                <input type="text" name="username_agency" class="form-control" aria-label="Sizing example input"
                       aria-describedby="inputGroup-sizing-lg" value="{{ $agencyUser->username_agency }}">
            </div>
            <!-- Thêm mã HTML và kiểm tra lỗi -->

            <div class="input-group mt-2 input-group-lg">
                <span class="input-group-text text-capitalize" id="inputGroup-sizing-lg">Email đại lý</span>
                <input type="text" name="email_user_agency" class="form-control" aria-label="Sizing example input"
                       aria-describedby="inputGroup-sizing-lg" value="{{ $agencyUser->email }}">
            </div>
            <!-- Thêm mã HTML và kiểm tra lỗi -->

            <div class="input-group mt-2 input-group-lg">
                <span class="input-group-text text-capitalize" id="inputGroup-sizing-lg">Mật khẩu đại lý</span>
                <input type="password" name="password_user_agency" class="form-control" aria-label="Sizing example input"
                       aria-describedby="inputGroup-sizing-lg" value="">
                <!-- Không nên hiển thị mật khẩu cũ -->
            </div>
            <!-- Thêm mã HTML và kiểm tra lỗi -->

            <div class="input-group mt-2 input-group-lg">
                <span class="input-group-text text-capitalize" id="inputGroup-sizing-lg">Chiết khấu</span>
                <input type="text" name="commission_rate" class="form-control" aria-label="Sizing example input"
                       aria-describedby="inputGroup-sizing-lg" value="{{ $commissionRate }}">
            </div>
            <!-- Thêm mã HTML và kiểm tra lỗi -->

            <div class="form-group">
                <label for="agency_id">Đại lý:</label>
                <select class="form-control" name="agency_id" required>
                    @foreach ($agencies as $agency)
                        <option value="{{ $agency->id }}" {{ $agency->id == $agencyUser->agency_id ? 'selected' : '' }}>
                            {{ $agency->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <!-- Thêm mã HTML và kiểm tra lỗi -->

            <button type="submit" class="btn btn-info mt-3">Cập nhật Tài Khoản Đại Lý</button>
        </form>
    </div>
@endsection
