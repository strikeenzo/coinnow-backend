<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function seller() {
        return $this->belongsTo('App\Models\Seller', 'user_id', 'id');
    }
}
