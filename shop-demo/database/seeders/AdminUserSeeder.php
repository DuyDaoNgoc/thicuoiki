<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Xóa tài khoản admin cũ nếu tồn tại
        User::where('email', 'kinbingo48@gmail.com')->delete();

        // Tạo tài khoản admin mới
        User::create([
            'name' => 'Duy Dao Ngoc',
            'email' => 'kinbingo48@gmail.com',
            'password' => bcrypt('duypro0478'), // Mã hóa mật khẩu
            'role' => 'admin',                 // Đặt role là admin
           'is_admin' => true, // Đảm bảo is_admin là true khi tạo admin
        ]);
    }
}