<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ClientShortener extends Model
{

    protected $table = 'client_shorteners';

    protected $primaryKey = 'id_number';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_client', 'api_key'
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
