<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'status',
        'amount',
        'payment_date',
        'project_id',
    ];
    protected $casts = [
        'amount' => 'float',
        'payment_date' => 'datetime',
        'project_id' => 'integer',
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }
}
