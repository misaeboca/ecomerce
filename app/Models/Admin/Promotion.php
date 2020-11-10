<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{

    protected $table = 'promotions';

    protected $primaryKey = 'id_number';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'start', 'end', 'id_client', 'description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id_number', 'id_client'];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

}
