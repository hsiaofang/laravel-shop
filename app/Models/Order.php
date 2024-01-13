<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['name', 'email', 'cart', 'uuid', 'paid', 'user_id']; 

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $attributes = [
        'user_id' => 1,
    ];
    
}
