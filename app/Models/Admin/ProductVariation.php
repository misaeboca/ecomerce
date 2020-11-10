<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{

    protected $table = 'products_variations';

    protected $primaryKey = 'id_number';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product', 'cod', 'sku', 'price', 'description', 'extra', 'ean13', 'itf14', 'launch'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id_number', 'product'];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;
}
