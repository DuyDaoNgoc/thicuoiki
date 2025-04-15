<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Mối quan hệ một-nhiều với model Product.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}