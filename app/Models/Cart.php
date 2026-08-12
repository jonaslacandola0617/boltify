<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasUuids;

    protected $fillable = ['userId'];

    public function user() { return $this->belongsTo(User::class, 'userId'); }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_product', 'cartId', 'productId')->withPivot('quantity');
    }
}
