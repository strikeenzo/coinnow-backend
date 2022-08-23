<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manufacturer extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','image','sort_order','status'];
    const ACTIVE = 1;

    public static function getActivePluck() {
        return self::select('name','id')->active()->pluck('name','id');
    }

    public function scopeActive($query) {
        return $query->where('status', self::ACTIVE);
    }
}
