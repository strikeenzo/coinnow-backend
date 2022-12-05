<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftHistory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function seller()
    {
        return $this->belongsTo('App\Models\Seller', 'seller_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
