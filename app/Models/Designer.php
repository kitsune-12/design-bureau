<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designer extends User
{
    protected $fillable = [
        'specialization_id',
    ];
    protected function casts(): array
    {
        return [
            'specialization_id' => 'int',
        ];
    }

}
