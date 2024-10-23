<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Country;

class State extends Model
{
    protected $fillable = [
        'name',
        'country_id',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
