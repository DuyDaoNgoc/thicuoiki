@extends('layouts.app')

@section('content')
    <div class="custom-container">
        <h1 class="title">Danh sách Người dùng</h1>
        
        <a href="{{ route('admin.users.create') }}" class="btn info">Tạo Người dùng mới</a>

        @if ($users->isEmpty())
            <div class="alert-warning">
                <p>Không có người dùng nào.</p>
            </div>
        @else
            <div class="table-wrapper">
                <ul class="custom-list">    
                    @foreach ($users as $user)
                        <li class="user-item">
                            <span class="user-info">{{ $user->name }} - {{ $user->email }}</span>
                            <div class="user-actions">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn info">Xem</a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn warning">Chỉnh sửa</a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn danger" onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">Xóa</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection


<style>
    .custom-container {
        max-width: 1280px;
        margin: 40px auto;
        padding: 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .title {
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 24px;
        color: #1f2937;
    }

    .alert-warning {
        background-color: #fff8e1;
        color: #b45309;
        padding: 16px;
        border-radius: 8px;
        text-align: center;
        font-weight: 500;
    }

    .table-wrapper {
        overflow-x: auto;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .custom-list {
        list-style-type: none;
        padding-left: 0;
    }

    .user-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #e5e7eb;
        padding: 14px;
        margin-bottom: 10px;
        border-radius: 8px;
        background-color: #fff;
    }

    .user-info {
        flex-grow: 1;
        color: #374151;
        font-weight: 500;
    }

    .user-actions {
        display: flex;
        gap: 10px;
    }

    .btn {
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: background-color 0.2s ease;
    }

    .btn.info {
        background-color: #3b82f6;
        color: #fff;
    }

    .btn.warning {
        background-color: #facc15;
        color: #1f2937;
    }

    .btn.danger {
        background-color: #ef4444;
        color: #fff;
        border: none;
    }

    .btn:hover {
        opacity: 0.9;
    }

    .inline-form {
        display: inline;
        margin-bottom: 0;
    }
</style>

