<?php
/**
 * Created by PhpStorm.
 * User: Gary
 * Date: 30/9/2017
 * Time: 3:43 PM
 */

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Rol
 *
 * @author Gary Romero
 */

class Rol extends Model
{

    protected $table = 'roles';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'description', ];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

}
