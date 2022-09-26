<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function owner() {
        return $this->belongsTo('App\Models\Seller', 'owner_id', 'id');
    }

    public function members() {
        return $this->hasMany('App\Models\Seller', 'clan_id', 'id');
    }

    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
