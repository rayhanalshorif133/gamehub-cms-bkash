<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrantToken extends Model
{
    use HasFactory;

    protected $table = 'grant_token'; // Explicitly defining the table name

    protected $fillable = [
        'token_type',
        'id_token',
        'refresh_token',
        'expires_time',
        'response',
    ];

    protected $casts = [
        'expires_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


}
