<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasUuids;

    protected $fillable = ['userId','total','status','payment_intent','payment_status','payment_method','name','email','address','city','country','refund','refund_status','refund_reason','refund_completed_at','stock_deducted'];

    protected function casts(): array
    {
        return ['total' => 'integer', 'stock_deducted' => 'boolean', 'refund_completed_at' => 'datetime'];
    }

    public function user() { return $this->belongsTo(User::class, 'userId'); }
    public function products() { return $this->belongsToMany(Product::class, 'order_product', 'orderId', 'productId')->withPivot('quantity', 'unit_price'); }
}
