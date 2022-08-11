<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subtask extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'task_id',
        'staff_id',
        'titre',
        'deadline',
        'description',
        'etat'
    ];

    public function task()
    {
        return $this->belongsTo(task::class);
    }
    public function staff()
    {
        return $this->belongsTo(staff::class);
    }
    
}
