<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Cart extends Authenticatable
{
    use SoftDeletes;
    protected $table = 'cart';
    protected $fillable = ['customer_id', 'product_id', 'seller_id', 'option', 'quantity', 'date_added'];
    protected $primaryKey = 'cart_id';
}
