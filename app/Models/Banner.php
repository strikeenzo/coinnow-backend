<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    protected $table = 'banner';
    use SoftDeletes;
    protected $fillable = ['name','status'];

//    protected $primaryKey = 'category_id';

    public function images() {
        return $this->hasMany('App\Models\BannerImage','banner_id','id');
    }
}
