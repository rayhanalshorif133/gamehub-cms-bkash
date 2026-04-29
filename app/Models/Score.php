<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'subscription_id',
        'msisdn',
        'score',
        'durations',
        'mac',
        'encrypted_score',
        'game_keyword',
        'status',
        'device_type',
        'user_mac',
        'message',
        'date_time',
        'hit_url',
    ];

}
