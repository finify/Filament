<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Country;
use App\Models\City;
use App\Models\State;
use App\Models\Department;

class Employee extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'phone',
        'address',
        'zip_code',
        'city_id',
        'state_id',
        'country_id',
        'department_id',
        'date_hired',
        'date_resigned',
        'date_of_birth',
    ];


    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }


    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }


    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }


    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }


}
