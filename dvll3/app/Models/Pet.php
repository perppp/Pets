<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = ['name', 'type', 'age', 'status'];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function adoptionLogs()
    {
        return $this->hasMany(AdoptionLog::class);
    }
}