<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRelated extends Model
{
    protected $table = 'product_related';
    protected $fillable = ['product_id','related_id'];

    public static function getRelatedIds($id) {
        return self::whereProductId($id)->pluck('related_id')->toArray();
    }
}
