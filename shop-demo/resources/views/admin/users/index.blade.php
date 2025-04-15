<!-- resources/views/admin/users/index.blade.php -->
@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Người dùng</title>
</head>
<body>
    <h1>Danh sách Người dùng</h1>
    <a href="{{ route('admin.users.create') }}">Tạo Người dùng mới</a>
    <ul>
        @foreach ($users as $user)
            <li>{{ $user->name }} - {{ $user->email }}
                <a href="{{ route('admin.users.show', $user->id) }}">Xem</a> |
                <a href="{{ route('admin.users.edit', $user->id) }}">Chỉnh sửa</a> |
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Xóa</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
@endsection