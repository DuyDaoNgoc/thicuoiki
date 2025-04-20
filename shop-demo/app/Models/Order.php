<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'product_id',      // Thêm để liên kết với sản phẩm
        'ten_san_pham',
        'size',
        'tong_tien',
        'ngay_mua',
        'ngay_giao',
        'user_id',
        'nguoi_dat',
    ];

    /**
     * Một đơn hàng thuộc về một người dùng.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Một đơn hàng thuộc về một sản phẩm.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}