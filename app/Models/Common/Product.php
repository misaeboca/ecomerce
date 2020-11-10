<?php

namespace App\Models\Common;

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

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id_number', 'old_price', 'ean13', 'id_payment', 'itf14', 'extra', 'alternative_names', 'status', 'created_at', 'updated_at', 'deleted_at', 'id_client', 'codProduct'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public $timestamps = true;

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product', 'sku')->select([
            'product',
            "cod",
            "sku",
            "url",
            "height",
            "width"
        ]);
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

}
