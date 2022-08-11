<?php

namespace App\Models;

use App\Traits\CustomFileTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Special extends Model
{
    use CustomFileTrait,SoftDeletes;
    protected $table = 'special';

    protected $fillable = ['product_id', 'quantity', 'seller_id'];

    public function seller () {
        return $this->belongsTo('App\Models\Seller','seller_id','id');
    }

    public function product () {
        return $this->belongsTo('App\Models\Product','product_id','id');
    }
}
