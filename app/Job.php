<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'company_id', 'title', 'description'
    ];

    public function user()
    {
        return $this->hasManyThrough(\App\User::class, \App\Company::class);
    }
    
    public function company()
    {
        return $this->belongsTo(\App\User::class);
    }
}
