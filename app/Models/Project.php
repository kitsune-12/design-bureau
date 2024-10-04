<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'cost',
        'start_date',
        'end_date',
        'client_id',
        'designer_id',
        'payment_id',
    ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'cost' => 'float',
        'client_id' => 'integer',
        'designer_id' => 'integer',
        'payment_id' => 'integer',
    ];

    public function payment(){
        return $this->hasOne(Payment::class);
    }

    public  function client(){
        return $this->belongsTo(Client::class);
    }
    public function designer(){
        return $this->belongsTo(Designer::class);
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'material_in_projects', 'project_id', 'material_id')
            ->withPivot('quantity');
    }
}
