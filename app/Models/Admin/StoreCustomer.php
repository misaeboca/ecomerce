<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreCustomer extends Model
{

    protected $table = 'stores_customers';

    protected $primaryKey = 'id_number';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_store', 'id_customer'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id_number', 'deleted_at'];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

}
