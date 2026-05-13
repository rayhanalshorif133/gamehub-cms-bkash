<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamePlayLog extends Model
{
    use HasFactory;

    protected $table = 'game_play_logs';


    protected $fillable = [
        'date',
        'msisdn',
        'keyword',
        'score',
        'start_time',
        'end_time',
        'durations',
        'status',
    ];


    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
    ];
}
