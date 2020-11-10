<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';

    protected $primaryKey = 'id_number';

    const STATUS_PENDING = 'pending';
    const STATUS_REJECT = 'reject';
    const STATUS_APPROVED = 'approved';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'id_store', 'id_seller', 'id_share', 'id_delivery', 'id_payment', 'id_customer',
        'id_customer_address', 'total', 'status', 'observations', 'payment_response', 'subtotal',
        'delivery_cost', 'delivery_notify', 'register_date', 'delivery_response', 'delivery_response_process', 'payment_response_process',
        'withdraw', 'nota_fiscal', 'refund_response', 'refund_response_process'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id_number', 'id_store', 'id_share', 'id_delivery',
        'id_payment', 'id_customer', 'deleted_at', 'register_date',
        'delivery_response', 'payment_response', 'refund_response'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public $timestamps = true;

    public function store()
    {
        return $this->hasOne(Store::class, 'id', 'id_store');
    }

    public function share()
    {
        return $this->hasOne(Share::class, 'id', 'id_share');
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class, 'id', 'id_delivery');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'id', 'id_payment');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'id_customer');
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class, 'id_order', 'id')->with('product');
    }

    public function address()
    {
        return $this->hasOne(CustomerAddress::class, 'id', 'id_customer_address');
    }
}
