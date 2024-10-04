<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('admin', function ($builder) {
            $builder->where('role', 'admin');
        });
    }
}
