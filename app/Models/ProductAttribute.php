<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttribute extends Model
{

    use SoftDeletes;
    protected $fillable = ['name', 'group_id', 'status'];

    public function productGroup()
    {
        return $this->belongsTo('App\Models\ProductAttributeGroup', 'group_id', 'id');
    }
}
