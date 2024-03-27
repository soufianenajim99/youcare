<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condidature extends Model
{
    use HasFactory;
    protected $fillable =[
        'benevole_id',
        'annonce_id',
        'validated_at',
    ];

    public $incrementing = true;
}