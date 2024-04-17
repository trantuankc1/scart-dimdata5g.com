@extends($templatePathAdmin.'layout')

@section('main')
    <div class="container-fluid card ">
        <h2 class="text-capitalize text-center">cấp Đại Lý</h2>
        <a class="btn btn-success text-capitalize" style="width: 20%" href="{{ route('agency.create') }}">tạo cấp đại lý</a>
        <table class="table table-bordered table-hover text-center">
            <tr class="text-capitalize">
                <td>id</td>
                <td>mô tả</td>
            </tr>
            <tbody>
            @foreach($agencies as $agency)
                <tr>
                    <td>{{ $agency->id }}</td>
                    <td>{{ $agency->name }}</td>
                    <td><a href="{{ route('agencies.edit', $agency->id) }}" class="btn btn-info">Sửa</a></td>
                    <td>
                        <form id="delete-form-{{ $agency->id }}" action="{{ route('agencies.destroy', $agency->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" id="delete-button-{{ $agency->id }}" onclick="confirmDelete('{{ $agency->id }}', event)">xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function confirmDelete(agencyId, event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định của form

            if (confirm('Bạn có chắc chắn muốn xóa đại lý này không?')) {
                document.getElementById('delete-form-' + agencyId).submit();
            }
        }
    </script>
@endsection
