<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DOD extends Model
{

    use SoftDeletes;
    protected $fillable = ['product_id'];
    protected $table = 'dod';

    public function productDetails() {
        return $this->hasOne('App\Models\Product','id','product_id');
    }

    public function productDescription() {
        return $this->hasOne('App\Models\ProductDescription','product_id','product_id');
    }

    public function productSpecial() {
        return $this->hasOne('App\Models\ProductSpecial','product_id','product_id');
    }

    public static function getPluck() {
        return self::select('product_id','id')->pluck('product_id')->toArray();
    }

    public function productReview() {
      return $this->hasOne('App\Models\Review','product_id','product_id');
    }

    public function special() {
        return $this->hasOne('App\Models\ProductSpecial','product_id','product_id');
    }

}
