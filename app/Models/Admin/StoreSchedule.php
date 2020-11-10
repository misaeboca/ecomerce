<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class StoreSchedule extends Model
{

    protected $table = 'stores_schedules';

    protected $primaryKey = 'id_number';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_store', 'monday_opening', 'monday_closing', 'tuesday_opening', 'tuesday_closing', 'wednesday_opening','wednesday_closing', 'thursday_opening',
        'thursday_closing', 'friday_opening', 'friday_closing', 'saturday_opening', 'saturday_closing', 'sunday_opening', 'sunday_closing'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id_number'];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

}
