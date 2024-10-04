<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends User
{
    use HasFactory;

    public function project()
    {
        return $this->hasMany(Project::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('client', function ($builder) {
            $builder->where('role', 'client');
        });
    }
}
