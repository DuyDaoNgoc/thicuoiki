
<style>
    .register-container {
        max-width: 460px;
        margin: 80px auto;
        padding: 30px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        font-family: sans-serif;
    }

    .register-container h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #333;
    }

    .form-group {
        margin-bottom: 18px;
    }

    label {
        display: block;
        margin-bottom: 6px;
        color: #333;
        font-weight: 600;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    input:focus {
        border-color: #007BFF;
        outline: none;
    }

    .invalid-feedback {
        color: red;
        font-size: 13px;
        margin-top: 5px;
    }

    .register-actions {
        margin-top: 25px;
        text-align: center;
        display: flex
;
    flex-direction: column;
    }

    .register-actions button {
        background: #007BFF;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .register-actions button:hover {
        background: #0056b3;
    }

    .register-actions a {
        display: inline-block;
        margin-top: 10px;
        color: #007BFF;
        text-decoration: none;
        font-size: 14px;
    }

    .register-actions a:hover {
        text-decoration: underline;
    }
</style>

<div class="register-container">
    <h2>Đăng ký</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label for="name">Họ tên</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input id="password" type="password" name="password" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password-confirm">Xác nhận mật khẩu</label>
            <input id="password-confirm" type="password" name="password_confirmation" required>
        </div>

        <div class="register-actions">
            <button type="submit">Đăng ký</button>
            <a href="{{ route('login') }}">Đã có tài khoản? Đăng nhập</a>
        </div>
    </form>
</div>

