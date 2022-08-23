<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BannerImage extends Model
{
    protected $table = 'banner_image';

    protected $fillable = ['banner_id','title','link','image','sort_order'];

    public function banner() {
        return $this->belongsTo('App\Models\BannerImage','id','banner_id');
    }
}
