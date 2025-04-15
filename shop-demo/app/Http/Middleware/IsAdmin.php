<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra nếu người dùng đã đăng nhập và là admin
        if (auth()->check() && auth()->user()->is_admin) {
            return $next($request);
        }

        // Nếu không phải admin, trả về lỗi 403
        abort(403, 'Bạn không có quyền truy cập khu vực này.');
    }
}