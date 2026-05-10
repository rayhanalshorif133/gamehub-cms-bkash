<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'level_number',
        'game_id',
        'prize_id',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
    ];
}
