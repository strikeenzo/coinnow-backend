<?php

namespace App\Models;

use App\Traits\CustomFileTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use CustomFileTrait, SoftDeletes;
    protected $table = 'notification';

    protected $fillable = ['type', 'product_id', 'quantity', 'price', 'seller_id', 'receiver_id', 'sender_id', 'balance', 'amount', 'seen', 'clan_id'];

    protected $casts = [
        'price' => 'float',
        'balance' => 'float',
        'amount' => 'integer',
        'quantity' => 'integer',
    ];

    public function scopeSeen($query)
    {
        return $query->where('seen', 1);
    }

    public function seller()
    {
        return $this->belongsTo('App\Models\Seller', 'seller_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\Models\Seller', 'receiver_id', 'id');
    }

    public function sender()
    {
        return $this->belongsTo('App\Models\Seller', 'sender_id', 'id');
    }

    public function clan()
    {
        return $this->belongsTo('App\Models\Clan', 'clan_id', 'id');
    }
}
