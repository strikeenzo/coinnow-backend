<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
    use SoftDeletes;

    protected $fillable = ['order_id', 'product_id', 'name', 'special','image', 'quantity', 'price', 'total', 'reward'];
    protected $table = 'order_product';


  public function order() {
      return $this->belongsTo('App\Models\Order','order_id','id');
  }

}
