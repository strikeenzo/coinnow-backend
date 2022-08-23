<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $fillable = ['name','status'];
    protected $table = 'order_status';


    const ACTIVE = 1;

    public static function getActivePluck() {
        return self::select('name','id')->active()->pluck('name','id');
    }
    
    public function scopeActive($query) {
        return $query->where('status', self::ACTIVE);
    }
}
