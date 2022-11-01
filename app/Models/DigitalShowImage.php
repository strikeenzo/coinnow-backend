<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalShowImage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo('App\Models\Seller', 'owner_id', 'id');
    }

    public function sellers()
    {
        return $this->belongsToMany('App\Models\Seller', 'digital_show_image_seller_relations', 'image_id', 'user_id')->withPivot('heart', 'view_status');
    }
}
