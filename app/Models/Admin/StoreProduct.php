<?php

namespace App\Models\Admin;

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
    protected $hidden = ['id_number', 'id_store', 'created_at'];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

}
