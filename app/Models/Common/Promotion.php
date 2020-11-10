<?php

namespace App\Models\Common;

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

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id_number', 'created_at', 'updated_at', 'id_client'];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

    public function promotions_products()
    {
        return $this->hasMany(PromotionProduct::class, 'id_promotion', 'id');
    }
}
