<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class StoreBraspag extends Model
{

    protected $table = 'stores_braspag';

    protected $primaryKey = 'id_number';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_store', 'merchant_id', 'merchant_key'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id_number'];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

}
