<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin \Eloquent
 */

class Company extends Model
{
    
    protected $fillable = [
        'name',
        'email',
        'logo',
        'website',
    ];

    public function employees() : HasMany  
    {
        return $this->hasMany(Employee::class);
    }

    public function getLogoNameAttribute() 
    {
        return str_slug($this->name).'-'.$this->id;
    }
        
}
