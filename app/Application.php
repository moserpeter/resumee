<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id', 'company_id', 'send_at'
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function send()
    {
        return $this->belongs
    }

    public function getIsSentAttribute()
    {
        return ($this->send_at !== null);
    }
}
