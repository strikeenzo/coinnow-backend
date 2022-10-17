<?php

namespace App\Models;

use App\Traits\CustomFileTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Special extends Model
{
    use CustomFileTrait, SoftDeletes;
    protected $table = 'special';

    protected $fillable = ['product_id', 'quantity', 'seller_id'];

    public function seller()
    {
        return $this->belongsTo('App\Models\Seller', 'seller_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function productDescription()
    {
        return $this->hasOne('App\Models\ProductDescription', 'product_id', 'product_id');
    }
}
