<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $table = 'customers';

    protected $primaryKey = 'id_number';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_number', 'name', 'lastname', 'email', 'cpf', 'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id_number', 'deleted_at'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public $timestamps = true;

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_customer', 'id');
    }

    public function store()
    {
        return $this->hasMany(StoreCustomer::class, 'id_customer', 'id');
    }

}
