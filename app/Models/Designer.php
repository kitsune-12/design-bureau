<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designer extends User
{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = [
        'first_name',
        'last_name',
        'patronymic',
        'password',
        'role_id',
        'specialization_id',

    ];
    protected function casts(): array
    {
        return [
            'specialization_id' => 'int',
        ];
    }
    public function specialization(){
        return $this->hasOne(Specialization::Class);
    }

    public function project()
    {
        return $this->hasMany(Project::Class);
    }
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('designer', function ($builder) {
            $builder->whereHas('role', function ($query) {
                $query->where('role_name', 'designer');
            });
        });
    }

}
