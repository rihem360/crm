<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'staff_id',
        'titre',
        'deadline',
        'description',
        'etat'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function staff()
    {
        return $this->belongsTo(staff::class);
    }
    public function subtasks()
    {
        return $this->hasMany(subtasks::class);
    }
    
}
