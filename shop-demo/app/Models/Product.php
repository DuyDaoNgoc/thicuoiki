<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    // Các trường có thể được gán (mass assignable)
    protected $fillable = [
        'name', 
        'description', 
        'price', 
        'category_id', 
        'image', 
        'stock', 
        'is_featured',  // Thêm is_featured vào fillable
        'slug'  // Thêm slug vào fillable
    ];

    /**
     * Quan hệ với bảng Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    /**
     * Quan hệ với bảng Cart (nếu có).
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Quan hệ với bảng Order (nếu có).
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Lấy đường dẫn ảnh đầy đủ
     * Kiểm tra nếu tệp ảnh tồn tại trước khi trả về đường dẫn
     */
    public function getImageUrlAttribute()
    {
        return $this->image && file_exists(public_path('images/' . $this->image)) 
            ? asset('images/' . $this->image) 
            : asset('images/default-product.jpg'); // Hình ảnh mặc định nếu không có
    }

    /**
     * Lấy giá trị định dạng đẹp cho giá
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', '.') . ' đ';
    }

    /**
     * Tính toán số lượng tồn kho có thể bán
     */
    public function availableStock()
    {
        return $this->stock > 0 ? $this->stock : 0; // Nếu stock là 0 hoặc nhỏ hơn 0, trả về 0
    }

    /**
     * Tạo slug tự động từ tên sản phẩm
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (!$product->slug) {
                $product->slug = Str::slug($product->name); // Tạo slug từ tên sản phẩm
            }
        });
    }
}