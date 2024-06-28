@extends($templatePathAdmin.'layout')

@section('main')

    <div class="container card">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-capitalize text-center">danh sách đại lý</h3>
                <a class="btn btn-success text-capitalize" href="{{ route('agency_users.create') }}">tạo mới đại lý</a>

                <table class="table table-bordered table-hover mt-2">
                    <tr class="text-capitalize">
                        <td>id</td>
                        <td>tên đại lý</td>
                        <td>email</td>
                        <td>cấp đại lý</td>
                        <td>chiết khấu</td>
                    </tr>
                    <tbody>
                    @foreach($agencyUsers as $agencyUser)
                        <tr>
                            <td>{{ $agencyUser->id }}</td>
                            <td>{{ $agencyUser->username }}</td>
                            <td>{{ $agencyUser->email }}</td>
                            @if($agencyUser->agency && $agencyUser->agency->level != null)
                                {{ $agencyUser->agency->level }}
                            @else
                                N/A <!-- Display a default value if agency or level is null -->
                            @endif
                            <td>
                                @foreach($agencyUser->commissions as $commission)
                                    {{ $commission->commission_rate }} %
                                    <br> <!-- Thêm dòng mới sau mỗi tỉ lệ chiết khấu -->
                                @endforeach
                            </td>
                            <td><a href="{{ route('agency_users.edit', $agencyUser->id) }}" class="btn btn-info">sửa</a>
                            </td>
                            <td>
                                <form id="delete-form-{{ $agencyUser->id }}"
                                      action="{{ route('agency_users.destroy', $agencyUser->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" id="delete-button-{{ $agencyUser->id }}"
                                            onclick="confirmDelete('{{ $agencyUser->id }}', event)">xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function confirmDelete(agencyUserId, event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định của form

            if (confirm('Bạn có chắc chắn muốn xóa đại lý này không?')) {
                document.getElementById('delete-form-' + agencyUserId).submit();
            }
        }
    </script>
@endsection
