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
 * Description of RolUser
 *
 * @author Gary Romero
 */

class RolUser extends Model
{

    protected $table = 'rol_user';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'rol_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

    public function rolName()
    {
        return $this->hasOne(Rol::class, 'id', 'rol_id');
    }

    public function usuario()
    {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }

    public function usuarios()
    {
        return $this->hasMany(User::class, 'user_id', 'user_id');
    }

}


