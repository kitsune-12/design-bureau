<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialInProject extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'material_id',
        'project_id',
        'quantity',
    ];

    protected $casts = [
        'material_id' => 'integer',
        'project_id' => 'integer',
        'quantity' => 'integer',
    ];

    public function project()
    {
        return $this->belongsTo(Project::Class);
    }

    public function material(){
        return $this->belongsTo(Material::Class);
    }
}
