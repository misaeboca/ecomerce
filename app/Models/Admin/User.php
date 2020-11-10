<?php

namespace App\Models\Admin;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use JWTAuth;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, SoftDeletes;

    protected $table = 'users';

    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'status', 'code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'password', 'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * The attributes that should be dates for arrays.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public $timestamps = true;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getRolesAttribute()
    {
        return $this->belongsToMany(Rol::class)->get();
    }

    public function rol()
    {
        return $this->hasOne(RolUser::class, 'user_id', 'id_number')->with('rolName');
    }

    public function hasRole($role)
    {
        if (is_array($role))
        {
            return $this->roles->whereIn('name', $role)->count() ? true : false;
        }

        return $this->roles->where('name', $role)->count() ? true : false;
    }

    public static function isAuthenticate()
    {
        return JWTAuth::parseToken()->authenticate();
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class, 'id_user', 'code')->select(['id_user', 'name', 'lastName', 'birthday', 'description']);
    }

    public function store_user()
    {
        return $this->hasOne(StoreUser::class, 'id_user', 'code')->with('store');
    }

    public function shares()
    {
        return $this->hasMany(Share::class, 'id_user', 'code');
    }

    public function stores()
    {
        return $this->hasMany(StoreUser::class, 'id_user', 'code')->with('store');
    }

}
