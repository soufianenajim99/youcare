<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class benevole extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function annonce(): BelongsToMany
    {
        return $this->belongsToMany(Annonce::class,'condidature')->withPivot('validated_at')->as('condidature')->withTimestamps()->using(Condidature::class);
    }
}