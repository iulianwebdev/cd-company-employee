<?php

namespace App;

use Illuminate\Database\Eloquent\Concerns\belongsTo;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Eloquent
 */
class Employee extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'company_id',
    ];

    public function company() : belongsTo 
    {
        return $this->belongsTo(Company::class);
    }
}
