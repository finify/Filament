<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Employee;

class Department extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function employees():HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
