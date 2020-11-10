<?php
/**
 * Created by PhpStorm.
 * User: Gary
 * Date: 08/07/2020
 * Time: 3:43 PM
 */

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of UserProfile
 *
 * @author Gary Romero
 */

class UserProfile extends Model
{

    protected $table = 'users_profile';

    protected $primaryKey = 'id_number';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_user', 'name', 'lastName', 'birthday', 'description'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id_number', 'created_at', 'updated_at', 'deleted_at'];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

    public function usuario()
    {
        return $this->hasOne(User::class, 'id_number', 'id_user');
    }

}


