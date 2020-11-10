<?php

namespace App\Models\Common;

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
        'id', 'id_store', 'name', 'lastname', 'email', 'cpf', 'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id_number', 'created_at', 'updated_at', 'deleted_at'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public $timestamps = true;

    public function address()
    {
        return $this->hasMany(CustomerAddress::class, 'id_customer', 'id_customer')->where('type', '=', 'address');
    }

    public function deliveryAddress()
    {
        return $this->hasMany(CustomerAddress::class, 'id_customer', 'id_customer')->where('type', '=', 'delivery');
    }
}
