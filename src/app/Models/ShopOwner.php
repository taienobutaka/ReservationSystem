<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ShopOwner extends Authenticatable
{
    use HasFactory;

    protected $table = 'owners'; // テーブル名を 'owners' に設定

    protected $fillable = [
        'name', 'email', 'password', 'shop_id'
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
