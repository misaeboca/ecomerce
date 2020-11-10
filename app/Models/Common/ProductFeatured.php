<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class ProductFeatured extends Model
{

    protected $table = 'products_featureds';

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
    protected $hidden = ['id_number', 'created_at', 'updated_at'];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

}
