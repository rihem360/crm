<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teams extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pseudo'
    ];

    public function staff()
    {
        return $this->belongsToMany(staff::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

}
