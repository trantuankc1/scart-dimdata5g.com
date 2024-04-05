@extends($templatePathAdmin.'layout')

@section('main')
    <div class="container">
        <h2>Đại Lý</h2>
        <a class="btn btn-success text-capitalize" href="{{ route('agency.create') }}">tạo mới đại lý</a>
        <table class="table table-bordered text-capitalize table-bordered table-hover">
            <tr>
                <td>ID</td>
                <td>Cấp Đại Lý</td>
            </tr>
            <tbody>
            @foreach($agencies as $agency)
                <tr>
                    <td>{{ $agency->id }}</td>
                    <td>{{ $agency->name }}</td>
                    <td><a class="btn btn-info" href="{{ route('agencies.edit', $agency->id) }}">Sửa</a></td>
                    <td>
                        <form method="POST" action="{{ route('agencies.destroy', $agency->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection