<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProductSpecial extends Model
{
    protected $table = 'product_special';
    protected $fillable = ['product_id','price','start_date','end_date'];
    public $timestamps = false;
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
