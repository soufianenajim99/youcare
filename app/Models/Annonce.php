<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Annonce extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'description',
        'localisation',
        'date',
        'comps',
        'organisateur_id'
    ];

    public function organisateur(){
        return $this->belongsTo(Organisateur::class);
    }

    public function benevoles(): BelongsToMany
    {
      
        return $this->belongsToMany(Benevole::class,'condidature')->withPivot('validated_at')->as('condidature')->withTimestamps()->using(Condidature::class);
    }
}