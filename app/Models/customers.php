<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customers extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cgpi_id',
        'name',
        'email',
        'num_tel',
        'raison_sociale',
        'location',
        'industry',
        'aum'
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

    public function cgpi()
    {
        return $this->belongsTo(cgpi::class);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
