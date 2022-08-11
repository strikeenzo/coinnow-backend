<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPrice extends Model
{
    use SoftDeletes;
    protected $table = 'product_price';
    protected $fillable = ['product_id','price', 'date'];

    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
