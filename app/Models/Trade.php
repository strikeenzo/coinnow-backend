<?php

namespace App\Models;

use App\Traits\CustomFileTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trade extends Model
{
    use CustomFileTrait, SoftDeletes;
    protected $table = 'trade';

    protected $casts = [
        'quantity' => 'integer',
        'min_reward' => 'integer',
        'max_reward' => 'integer',
        'quantity_trade' => 'integer',
        'image' => 'string',
        'product_image' => 'string',
        'product_id' => 'integer',
        'coin_quantity' => 'integer',
    ];

    protected $fillable = [
        'quantity',
        'min_reward',
        'max_reward',
        'quantity_trade',
        'image',
        'product_id',
        'product_image',
        'coin_quantity',
        'origin_id',
    ];

    public static $fillableValue = [
        'quantity',
        'min_reward',
        'max_reward',
        'quantity_trade',
        'image',
        'product_id',
        'origin_id',
        'product_image',
        'coin_quantity',
    ];
}
