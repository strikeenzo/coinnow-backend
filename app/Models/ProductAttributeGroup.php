<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttributeGroup extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'status'];
    const ACTIVE = 1;

    public function relationAttributes()
    {
        return $this->hasMany('App\Models\ProductAttribute', 'group_id', 'id');
    }

    public static function getActivePluck()
    {
        return self::active()->get()->pluck('name', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::ACTIVE);
    }
}
