<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;
    protected $table = 'pages';
    protected $fillable = ['title','heading','image','description'];


    public static function getActivePluck() {
        return self::active()->pluck('title','heading','image','description','id');
    }

    public function scopeActive($query) {
        return $query->where('status', self::ACTIVE);
    }
}
