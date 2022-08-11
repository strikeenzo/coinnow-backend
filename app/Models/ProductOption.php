<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOption extends Model
{
    protected $fillable = ['name', 'type', 'status'];
    use SoftDeletes;
    const ACTIVE = 1;

    public static function CheckType($type) {
        return in_array($type,config('constant.product_option')['Choose']);
    }

    public static function getActivePluck() {
        return self::select('name','id','type')->active()->get();
    }

    public function scopeActive($query) {
        return $query->where('status', self::ACTIVE);
    }

}
