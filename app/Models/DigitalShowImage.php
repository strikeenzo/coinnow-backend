<?php

namespace App\Models;

use App\Models\DigitalShowImageSellerRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalShowImage extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['view_counts'];
    public function owner()
    {
        return $this->belongsTo('App\Models\Seller', 'owner_id', 'id');
    }

    public function sellers()
    {
        return $this->belongsToMany('App\Models\Seller', 'digital_show_image_seller_relations', 'image_id', 'user_id')->withPivot('heart', 'view_status');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\DigitalImageComment', 'image_id', 'id');
    }

    public function contests()
    {
        return $this->belongsToMany('App\Models\Contest', 'contest_star_relations', 'digital_id', 'contest_id')->withPivot('investment');
    }

    public function getViewCountsAttribute()
    {
        return DigitalShowImageSellerRelation::where('image_id', $this->id)->count();
    }
}
