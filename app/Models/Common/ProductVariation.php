<?php

namespace App\Models\Common;

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

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id_number', 'product', 'created_at', 'updated_at', 'extra', 'product'];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

}
