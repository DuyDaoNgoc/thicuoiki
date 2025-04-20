@extends('layouts.app')

@section('content')
    <div class="custom-container">
        <h1 class="title">Chỉnh sửa Người dùng</h1>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Tên người dùng</label>
                <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>

            <div class="form-group">
                <label for="role">Vai trò</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Người dùng</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <button type="submit" class="btn info">Cập nhật</button>
        </form>
    </div>
@endsection

<style>
    .custom-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .btn.info {
        background-color: #3b82f6;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
    }

    .btn.info:hover {
        opacity: 0.9;
    }
</style>
    