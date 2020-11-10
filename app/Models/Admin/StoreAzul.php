<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class StoreAzul extends Model
{

    protected $table = 'stores_azul';

    protected $primaryKey = 'id_store';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_store', 'id_number', 'store', 'merchant_id', 'merchant_key'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public $timestamps = true;

}
