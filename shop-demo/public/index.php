<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Kiểm tra nếu ứng dụng đang trong chế độ bảo trì
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Đăng ký AutoLoader để tự động tải các lớp của ứng dụng
require __DIR__.'/../vendor/autoload.php';

// Chạy ứng dụng Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

// Tạo đối tượng Kernel để xử lý HTTP Request
$kernel = $app->make(Kernel::class);

// Xử lý yêu cầu và gửi phản hồi
$response = $kernel->handle(
    $request = Request::capture()
)->send();

// Kết thúc xử lý (chạy các tác vụ sau khi gửi phản hồi)
$kernel->terminate($request, $response);