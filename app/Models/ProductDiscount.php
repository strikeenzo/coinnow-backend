<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
    public $timestamps = false;
    protected $table = 'product_discount';
    protected $fillable = ['product_id', 'quantity', 'sort_order_discount', 'price', 'start_date', 'end_date'];

    //    public function setStartDateAttribute($value) {
//        $this->attributes['start_date'] = Carbon::parse($value)->toDateString();
//    }
//
    public function getStartDateAttribute($value) {
        return Carbon::parse($value)->format(config('constant.date_format')['custom_date_format']);
    }
//
//    public function setEndDateAttribute($value) {
//        $this->attributes['end_date'] = Carbon::parse($value)->toDateString();
//    }
//
    public function getEndDateAttribute($value) {
        return Carbon::parse($value)->format(config('constant.date_format')['custom_date_format']);
    }
}
