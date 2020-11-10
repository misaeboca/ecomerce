<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PromotionProduct extends Model
{

    protected $table = 'promotions_products';

    protected $primaryKey = 'id_number';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'id_promotion', 'product', 'id_store'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id_number'];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

    public function products()
    {
        return $this->hasMany(Product::class, 'sku', 'product');
    }
}
