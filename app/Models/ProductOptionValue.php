<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOptionValue extends Model
{
    public $timestamps = false;
    protected $table = 'product_option_values';
    protected $fillable = ['product_option_id', 'name', 'image', 'sort_order'];

    public static function getOptionValueById($optionId) {
        return self::where('product_option_id',$optionId)->get();
    }
}
