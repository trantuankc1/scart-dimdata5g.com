@extends('dashboard_agency.layout.app')
@section('content')

    <div class="container card" style="padding-bottom: 10px">
        <h2 class="text-center text-capitalize">Tạo đại lý</h2>
        <form id="agency_user_form" action="{{ route('agency_child.process_store') }}" method="post">
            @csrf
            @method('POST')
            <input type="hidden" name="parent_agency_id" value="{{ is_array($parentAgencyId) ? $parentAgencyId['id'] : $parentAgencyId }}">

            <div class="form-group">
                <label for="username">Tên Đại Lý:</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="discount_rate">Mức chiết khấu:</label>
                <input type="number" name="discount_rate" id="discount_rate" class="form-control" required max="{{ $parentAgencyCommission->commission_rate }}">
            </div>
            <div class="form-group">
                <label for="agency_id">cấp đại lý:</label>
                <select class="form-select" id="agency_id" aria-label="Default select example" name="agency_id">
                    @foreach($agencyLevels as $id => $name)
                        <option value="{{ $name->id }}" data-level="{{ $name->level }}">{{ $name->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Trường ẩn để lưu cấp độ của đại lý -->
            <input type="hidden" name="agency_level" id="agency_level_hidden">

            <button type="submit" class="btn btn-info mt-3">Tạo mới tài khoản đại lý</button>
        </form>
    </div>

    <script>
        document.getElementById('agency_id').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var agencyLevel = selectedOption.getAttribute('data-level');

            // Cập nhật giá trị của trường ẩn agency_level
            document.getElementById('agency_level_hidden').value = agencyLevel;
        });
    </script>
@endsection
