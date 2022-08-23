<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRelatedAttribute extends Model
{
    protected $table = 'product_related_attributes';
    protected $fillable = ['product_id','attribute_id','text'];

    public static function pluckByProduct($id) {
        return self::whereProductId($id)->pluck('text','attribute_id')->toArray();
    }

    public static function deleteByProduct($id) {
        return self::whereProductId($id)->delete();
    }
}
