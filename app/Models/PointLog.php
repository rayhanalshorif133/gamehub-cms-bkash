<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointLog extends Model
{
    use HasFactory;


    protected $table = 'point_logs'; 


    
    protected $fillable = [
        'user_id',
        'campaign_id',
        'phone',
        'point',
        'status',
        'type',
        'message',
        'date',
        'time',
    ];
}
