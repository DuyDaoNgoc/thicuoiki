
<style>
    .login-container {
        max-width: 420px;
        margin: 80px auto;
        padding: 30px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        font-family: sans-serif;
    }

    .login-container h2 {
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

    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    input[type="email"]:focus,
    input[type="password"]:focus {
        border-color: #007BFF;
        outline: none;
    }

    .invalid-feedback {
        color: red;
        font-size: 13px;
        margin-top: 5px;
    }

    .form-check {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }

    .form-check input {
        margin-right: 8px;
    }

    .login-actions {
        margin-top: 25px;
        text-align: center;
        display: flex
;
    flex-direction: column;
    }

    .login-actions button {
        background: #007BFF;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .login-actions button:hover {
        background: #0056b3;
    }

    .login-actions a {
        display: inline-block;
        margin-top: 10px;
        color: #007BFF;
        text-decoration: none;
        font-size: 14px;
    }

    .login-actions a:hover {
        text-decoration: underline;
    }
</style>

<div class="login-container">
    <h2>Đăng nhập</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
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

        <div class="form-check">
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label for="remember">Ghi nhớ đăng nhập</label>
        </div>

        <div class="login-actions">
            <button type="submit">Đăng nhập</button>
        
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
            @endif
        
            <a href="{{ route('register') }}">Chưa có tài khoản? Đăng ký</a>
        </div>
        
    </form>
</div>

