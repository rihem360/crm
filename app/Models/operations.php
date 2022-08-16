<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class operations extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'documents_id',
        'nature_operation',
        'montant_HT',
        'montant_TVA'
    ];

    public function document()
    {
        return $this->belongsTo(Documents::class);
    }
    
}
