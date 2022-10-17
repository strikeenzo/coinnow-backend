<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cron extends Model
{
    use SoftDeletes;
    protected $table = 'cron';
    protected $fillable = ['success'];
}
