<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class documents extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'contact_id',
        'info_supp',
        'type_doc',
        'etat',
        'montant_HT'
    ];

    public function operations()
    {
        return $this->hasMany(Operation::class);
    }
}
