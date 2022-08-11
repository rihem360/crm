<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class staff extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'num_tel',
        'role',
        'CV',
        'image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'created_at',
        'updated_at'
    ];

    public function teams()
    {
        return $this->belongsToMany(team::class);
    }
    public function responses()
    {
        return $this->hasMany(Response::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
        
    }
    
}
