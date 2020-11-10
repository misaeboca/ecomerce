<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;

    protected $table = 'stores';

    protected $primaryKey = 'id_number';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'id_client', 'name', 'country', 'city', 'address', 'cep', 'sigla', 'email', 'phone', 'logo', 'domain', 'coordinates',
        'google_tag_manager', 'google_tag_manager_body', 'pickup', 'loggi_address', 'status', 'has_delivery'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id_number', 'id_client', 'deleted_at'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public $timestamps = true;

    public function products()
    {
        return $this->hasMany(StoreProduct::class, 'id_store', 'id');
    }

    public function loggi()
    {
        return $this->hasOne(StoreLoggi::class, 'id_store', 'id');
    }

    public function schedules()
    {
        return $this->hasOne(StoreSchedule::class, 'id_store', 'id');
    }

    public function braspag()
    {
        return $this->hasOne(StoreBraspag::class, 'id_store', 'id');
    }
}
