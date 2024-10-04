<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'type',
        'description',
        'stock_availability',
    ];

    protected $casts = [
        'stock_availability' => 'integer',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'material_in_projects', 'material_id', 'project_id')
            ->withPivot('quantity');
    }


}
