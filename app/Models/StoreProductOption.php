<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreProductOption extends Model
{
    public $timestamps = false;
    protected $fillable = ['product_id', 'option_id', 'color_code', 'label', 'price', 'required'];
    protected $table = 'store_product_option';

    public function Product()
    {
        return $this->hasMany('App\Models\Product', 'id', 'product_id');
    }

}
