<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tickets extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'projet_id',
        'titre',
        'description',
        'file'
    ];

    public function contact()
    {
        return $this->belongsTo(contact::class);
    }
    public function project()
    {
        return $this->hasOne(Project::class);
    }
    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
