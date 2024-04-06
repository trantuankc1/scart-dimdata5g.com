@extends($templatePathAdmin.'layout')

@section('main')
    <div class="container">
        <h3 class="text-capitalize text-center">tạo đại lý</h3>
        <form action="{{ route('agency_users.store') }}" method="POST">
            @csrf
                <div class="input-group input-group-lg">
                    <span class="input-group-text text-capitalize" id="inputGroup-sizing-lg">tên đại lý</span>
                    <input type="text" name="username_agency" class="form-control" aria-label="Sizing example input"
                           aria-describedby="inputGroup-sizing-lg" value="{{ old('username_agency') }}">
                </div>
            @if($errors->has('username_agency'))
                <div class="alert alert-danger" role="alert">
                    chưa nhập tên đại lý
                </div>
            @endif

            <div class="input-group mt-2 input-group-lg">
                <span class="input-group-text text-capitalize" id="inputGroup-sizing-lg">Email đại lý</span>
                <input type="text" name="email_user_agency" class="form-control" aria-label="Sizing example input"
                       aria-describedby="inputGroup-sizing-lg" value="{{ old('email_user_agency') }}">
            </div>
            @if($errors->has('email_user_agency'))
                <div class="alert alert-danger" role="alert">
                    chưa nhập email đại lý
                </div>
            @endif

            <div class="input-group mt-2 input-group-lg">
                <span class="input-group-text text-capitalize" id="inputGroup-sizing-lg">mật khẩu đại lý</span>
                <input type="password" name="password_user_agency" class="form-control" aria-label="Sizing example input"
                       aria-describedby="inputGroup-sizing-lg" value="{{ old('password_user_agency') }}">
            </div>
            @if($errors->has('password_user_agency'))
                <div class="alert alert-danger" role="alert">
                    chưa nhập mật khẩu
                </div>
            @endif

            <div class="input-group mt-2 input-group-lg">
                <span class="input-group-text text-capitalize" id="inputGroup-sizing-lg">chiết khấu</span>
                <input type="text" name="commission_rate" class="form-control" aria-label="Sizing example input"
                       aria-describedby="inputGroup-sizing-lg" {{ old('commission_rate') }}">
            </div>

            @if($errors->has('commission_rate'))
                <div class="alert alert-danger" role="alert">
                    chưa nhập chiết khấu
                </div>
            @endif

            <div class="form-group">
                <label for="agency_id">Đại lý:</label>
                <select class="form-control" name="agency_id" required>
                    <option value="">Chọn đại lý</option>
                    @foreach ($agencies as $agency)
                        <option value="{{ $agency->id }}">{{ $agency->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-info mt-3">Tạo Tài Khoản Đại Lý</button>
        </form>
    </div>
@endsection
