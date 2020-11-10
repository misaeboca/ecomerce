<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{

    protected $table = 'products_categories';

    protected $primaryKey = 'id_number';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product', 'id_category',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id_number'];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'id_category');
    }
}
