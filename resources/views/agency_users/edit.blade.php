@extends($templatePathAdmin.'layout')

@section('main')
    <form id="agency_user_form" action="{{ route('agency_users.update', $agencyUser->id) }}" method="post">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="username">Tên đại lý:</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ $agencyUser->username }}" required>
        </div>
        <!-- Các trường thông tin khác tương tự -->
        <div class="form-group">
            <label for="password">Mật khẩu:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" required value="{{ $agencyUser->email }}">
        </div>
        <div class="form-group">
            <label for="discount_rate">Mức chiết khấu:</label>
            <input type="number" name="discount_rate" id="discount_rate" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="agency_id">Chọn đại lý:</label>
            <select name="agency_id" id="agency_id" class="form-control">
                @foreach($agencies as $agency)
                    <option value="{{ $agency->id }}" data-level="{{ $agency->level }}">{{ $agency->name }}</option>
                @endforeach
            </select>
            <input type="hidden" name="agency_level" id="agency_level_hidden">
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật thông tin đại lý</button>
    </form>
    <script>
        document.getElementById('agency_id').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var agencyId = selectedOption.value;
            var agencyLevel = selectedOption.getAttribute('data-level');

            // Cập nhật giá trị của trường ẩn agency_level
            document.getElementById('agency_level_hidden').value = agencyLevel;
        });
    </script>
@endsection
