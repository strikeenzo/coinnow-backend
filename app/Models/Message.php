<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'sender_id', 'receiver_id'];

    public function sender()
    {
        return $this->belongsTo('App\Models\Seller', 'sender_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\Models\Seller', 'receiver_id', 'id');
    }
}
