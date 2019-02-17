<?php

namespace App;

use Illuminate\Database\Eloquent\Concerns\hasMany;
use Illuminate\Database\Eloquent\Model;

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

    public function employees() : hasMany  
    {
        return $this->hasMany(Employee::class);
    }

    public function getLogoNameAttribute() 
    {
        return str_slug($this->name).'-'.$this->id;
    }
        
}
