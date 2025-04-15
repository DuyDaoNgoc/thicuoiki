<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        // Kiểm tra nếu yêu cầu login bị giới hạn tần suất
        $this->ensureIsNotRateLimited();

        // Thử xác thực thông qua Auth::attempt()
        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            // Nếu không thành công, tăng số lần yêu cầu thất bại
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'), // Thông báo lỗi nếu thông tin đăng nhập không đúng
            ]);
        }

        // Xóa giới hạn tần suất khi đăng nhập thành công
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        // Nếu đã đạt giới hạn số lần đăng nhập sai, ngừng yêu cầu
        if (RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            event(new Lockout($this)); // Gửi sự kiện khi bị khóa

            $seconds = RateLimiter::availableIn($this->throttleKey()); // Thời gian còn lại để thử lại

            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60), // Chuyển đổi thành phút
                ]),
            ]);
        }
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        // Tạo khóa duy nhất cho mỗi địa chỉ email và IP người dùng để giới hạn tần suất
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}