<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    // 定義與 User Model 的關聯
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 定義與 Product Model 的關聯
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
