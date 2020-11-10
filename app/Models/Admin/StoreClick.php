<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class StoreClick extends Model
{

    protected $table = 'stores_clicks';

    protected $primaryKey = 'id_number';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_store', 'id_seller', 'register_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id_number', 'register_date', 'updated_at', 'deleted_at'];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

}
