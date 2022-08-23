<?php

namespace App\Models;

use App\Traits\CustomFileTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use CustomFileTrait,SoftDeletes;
    protected $table = 'coupon';
    protected $fillable = ['name', 'code', 'type', 'discount', 'uses_total', 'status', 'date_added', 'start_date', 'end_date'];

    public static $fillableValue = ['name', 'code', 'type', 'discount', 'status', 'start_date', 'end_date'];

    public static function getActivePluck() {
        return self::select('name','id')->active()->pluck('name','id');
    }

    public function scopeActive($query) {
        return $query->where('status', self::ACTIVE);
    }


    public function setStartDateAttribute($value) {
        $this->attributes['start_date'] = $this->changeDateFormat($value,config('constant.date_format')['custom_date_format'],config('constant.date_format')['database_date_format']);
    }

    public function getStartDateAttribute($value) {
        return Carbon::parse($value)->format(config('constant.date_format')['custom_date_format']);
    }

    public function setEndDateAttribute($value) {
        $this->attributes['end_date'] = $this->changeDateFormat($value,config('constant.date_format')['custom_date_format'],config('constant.date_format')['database_date_format']);
    }

    public function getEndDateAttribute($value) {
        return Carbon::parse($value)->format(config('constant.date_format')['custom_date_format']);
    }
}
