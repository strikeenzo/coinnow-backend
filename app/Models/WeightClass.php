<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeightClass extends Model
{
    use SoftDeletes;
    protected $table = 'weight_class';
    protected $fillable = ['name','unit','value','status'];

    const ACTIVE = 1;

    public static function getActivePluck() {
        return self::select('name','id')->active()->pluck('name','id');
    }

    public function scopeActive($query) {
        return $query->where('status', self::ACTIVE);
    }

}
