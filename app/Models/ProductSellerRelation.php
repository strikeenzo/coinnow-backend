<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSellerRelation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function seller()
    {
        return $this->hasOne('App\Models\Seller', 'id', 'seller_id');
    }

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id')->orderBy('sort_order', 'ASC');
    }
}
