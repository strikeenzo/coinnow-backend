<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipping extends Model
{

    use SoftDeletes;
    protected $table = 'shipping';
    protected $fillable = ['name','shipping_charge','status'];

    const ACTIVE = 1;

    public static function getActivePluck() {
        return self::select('name','shipping_charge','id')->active()->pluck('name','shipping_charge','id');
    }

    public function scopeActive($query) {
        return $query->where('status', self::ACTIVE);
    }
}
