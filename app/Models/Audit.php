<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

    protected $fillable = [
        'event',
        'when',
        'user_id',
        'auditable_id',
        'auditable_type',
        'details'
    ];

    protected $casts = [
        'when'      => 'datetime',
        'details'   => 'json'
    ];
}
