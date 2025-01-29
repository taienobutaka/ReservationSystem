<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ShopOwner extends Authenticatable
{
    use HasFactory;

    protected $table = 'owners';

    protected $fillable = [
        'name', 'email', 'password'
    ];

    public function shops()
    {
        return $this->hasMany(Shop::class, 'owner_id');
    }
}
