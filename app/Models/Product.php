<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasUuids;

    protected $fillable = ['name','description','price','stock','images','categoryId'];

    protected function casts(): array { return ['price' => 'decimal:2', 'stock' => 'integer']; }

    public function carts() { return $this->belongsToMany(Cart::class, 'cart_product', 'productId', 'cartId')->withPivot('quantity'); }
    public function orders() { return $this->belongsToMany(Order::class, 'order_product', 'productId', 'orderId')->withPivot('quantity', 'unit_price'); }
    public function category() { return $this->belongsTo(Category::class, 'categoryId'); }
}
