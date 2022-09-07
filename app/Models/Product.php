<?php

namespace App\Models;

use App\Traits\CustomFileTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Product extends Model
{
    use CustomFileTrait,SoftDeletes;
    protected $table = 'product';

    protected $casts = [
        'price' => 'float',
        'min_price' => 'integer',
        'max_price' => 'integer',
        'quantity' => 'integer',
        'sale' => 'integer',
        'points' => 'integer',
        'seller_id' => 'integer',
        'origin_id' => 'integer'
    ];

    protected $fillable = [
        'category_id', 'model', 'quantity', 'stock_status_id', 'image',
        'manufacturer_id',  'price',  'tax_rate_id', 'date_available',
        'weight', 'weight_class_id', 'length', 'width', 'height', 'length_class_id',
        'points', 'min_price', 'max_price',
        'sort_order', 'status',
    ];

    public static $fillableValue = [   'category_id', 'model', 'quantity', 'stock_status_id', 'image',
        'manufacturer_id',  'price',  'tax_rate_id', 'date_available',
        'weight', 'weight_class_id', 'length', 'width', 'height', 'length_class_id',
        'points', 'min_price', 'max_price',
        'sort_order', 'status'];

    const ACTIVE = 1;

    public function scopeActive($query) {
        return $query->where('status', self::ACTIVE);
    }

    public function setDateAvailableAttribute($value) {
        $this->attributes['date_available'] = $this->changeDateFormat($value,config('constant.date_format')['custom_date_format'],config('constant.date_format')['database_date_format']);
    }

    public function getDateAvailableAttribute($value) {
        return Carbon::parse($value)->format(config('constant.date_format')['custom_date_format']);
    }

    public function productDescription() {
        return $this->hasOne('App\Models\ProductDescription','product_id','id');
    }

    public function images() {
        return $this->hasMany('App\Models\ProductImage','product_id','id');
    }

    public function attributes() {
        return $this->hasMany('App\Models\ProductRelatedAttribute','product_id','id');
    }

    public function special() {
        return $this->hasOne('App\Models\ProductSpecial','product_id','id');
    }

    public function specialItems() {
        return $this->hasMany('App\Models\Special','product_id','id');
    }

    public function history() {
        return $this->hasMany('App\Models\Notification','product_id','id');
    }

    public function discountProduct() {
        return $this->hasMany('App\Models\ProductDiscount','product_id','id');
    }

    public function category () {
        return $this->belongsTo('App\Models\CategoryDescription','category_id','category_id');
    }

    public function seller () {
        return $this->belongsTo('App\Models\Seller','seller_id','id');
    }

    public function productRelated() {
        return $this->hasMany('App\Models\ProductRelated','product_id','id');
    }

    public function productManufacturer() {
        return $this->belongsTo('App\Models\Manufacturer','manufacturer_id','id');
    }

    public function productReview() {
        return $this->hasMany('App\Models\Review','product_id','id');
    }

    public function productPrice() {
        return $this->hasMany('App\Models\ProductPrice','product_id','id')
            ->orderBy('created_at', 'DESC');
    }

    public function productPrices() {

        return $this->hasMany('App\Models\ProductPrice','product_id','id')
            ->orderBy('created_at', 'DESC')
            ->where('created_at', '>', Carbon::now()->subDays(30));
    }

    public function increment($column, $amount = 1, array $extra = array())
    {
        // $amount = -$amount;
        $wrapped = $this->grammar->wrap($column);

        $columns = array_merge(array($column => $this->raw("$wrapped - $amount")), $extra);

        return $this->update($columns);
    }

    public function sellers()
    {
        return $this->belongsToMany('App\Models\Seller', 'product_seller_relations', 'product_id', 'seller_id')->withPivot('sale_date', 'sell_date', 'sale', 'quantity', 'id', 'updated_at', 'created_at');
    }

}
