<!-- resources/views/admin/users/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Chi tiết Người dùng: {{ $user->name }}</h1>
        
        <div class="user-info">
            <p><strong>Tên:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Địa chỉ:</strong> {{ $user->address ?? 'Chưa cập nhật' }}</p>
            <p><strong>Số điện thoại:</strong> {{ $user->phone ?? 'Chưa cập nhật' }}</p>
        </div>

        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn warning">Chỉnh sửa</a>
        <a href="{{ route('admin.users.index') }}" class="btn info">Trở lại danh sách</a>
    </div>
@endsection


<style>
    .user-info {
        margin-top: 20px;
        padding: 10px;
        background-color: #f9fafb;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .user-info p {
        font-size: 16px;
        margin-bottom: 10px;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        margin-top: 20px;
    }

    .btn.warning {
        background-color: #facc15;
        color: #1f2937;
    }

    .btn.info {
        background-color: #3b82f6;
        color: #fff;
    }

    .btn:hover {
        opacity: 0.9;
    }
</style>
