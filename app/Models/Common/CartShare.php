<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class CartShare extends Model
{
    protected $table = 'carts_shares';

    protected $primaryKey = 'id_number';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'id_store', 'id_user', 'json'
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
