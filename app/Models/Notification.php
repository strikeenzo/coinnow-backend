<?php

namespace App\Models;

use App\Traits\CustomFileTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Notification extends Model
{
    use CustomFileTrait,SoftDeletes;
    protected $table = 'notification';

    protected $fillable = ['type', 'product_id', 'quantity', 'price', 'seller_id', 'receiver_id', 'sender_id', 'balance', 'amount', 'seen'];

    protected $casts = [
        'price' => 'float',
        'balance' => 'float',
        'amount' => 'integer',
        'quantity' => 'integer',
    ];

    public function scopeSeen($query) {
        return $query->where('seen', 1);
    }

    public function seller () {
        return $this->belongsTo('App\Models\Seller','seller_id','id');
    }

    public function product () {
        return $this->belongsTo('App\Models\Product','product_id','id');
    }

    public function receiver () {
        return $this->belongsTo('App\Models\Seller','receiver_id','id');
    }

    public function sender () {
        return $this->belongsTo('App\Models\Seller','sender_id','id');
    }
}
