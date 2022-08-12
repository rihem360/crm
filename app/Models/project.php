<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class project extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'team_id',
        'project_name',
        'description',
        'deadline',
        'date_debut',
        'etat'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
    public function team()
    {
        return $this->belongsTo(team::class);
    }
    public function tasks()
    {
        return $this->hasMany(task::class);
    }

}
