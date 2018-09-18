<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * returns the users applications
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applications()
    {
        return $this->hasMany(\App\Application::class);
    }

    /**
     * Retrieves all companies
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companies()
    {
        return $this->hasMany(\App\Company::class);
    }

    /**
     * Retrieves all Jobs
     *
     * @return Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function jobs()
    {
        return $this->hasManyThrough(\App\Job::class, \App\Company::class);
    }
}
