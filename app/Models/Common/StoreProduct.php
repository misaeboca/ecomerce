<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class StoreProduct extends Model
{

    protected $table = 'stores_products';

    protected $primaryKey = 'id_number';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_store', 'product', 'stock', 'cod', 'sku'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id_number', 'created_at', 'updated_at', 'product', 'id_store'] ;

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

}
