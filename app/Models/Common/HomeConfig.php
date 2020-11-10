<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class HomeConfig extends Model
{
    protected $table = 'home_config';

    protected $primaryKey = 'id_number';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'home'
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
