<?php

namespace App\Models\Common;

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

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id_number', 'id_promotion', 'created_at', 'updated_at', 'id_store'];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

    public function product()
    {
        return $this->hasOne(Product::class, 'sku', 'product')->with(['variations', 'images']);
    }
}
