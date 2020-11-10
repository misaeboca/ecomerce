<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    protected $primaryKey = 'id_number';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'alternative_names', 'sku',
        'type', 'material', 'theme',
        'html_description', 'html_short_description', 'tags', 'weight',
        'height', 'width', 'length', 'title',
        'desc', 'sale_price', 'old_price',
        'manufacturer', 'categories', 'ean13', 'id_payment', 'itf14', 'status', 'extra',
        'id_client', 'codProduct'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id_number', 'old_price', 'ean13', 'id_payment', 'itf14', 'extra', 'alternative_names', 'id_client'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public $timestamps = true;

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product', 'sku');
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class, 'product', 'sku')->select(
            [
            "product",
            "cod",
            "sku",
            "price",
            "description",
            "ean13",
            "launch",
            "itf14"
            ]);
    }

    public function categories()
    {
        return $this->hasMany(ProductCategory::class, 'product', 'sku')->with('category');
    }

}
