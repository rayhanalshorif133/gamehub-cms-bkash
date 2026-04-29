<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrafficLog extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * Laravel usually assumes 'traffic_logs', but it's good practice to define it.
     */
    protected $table = 'traffic_logs';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'tracking_id',
        'ip_address',
        'user_agent',
        'url',
        'msisdn',
        'is_paid',
        'send_notify',
    ];

    /**
     * The attributes that should be cast to native types.
     * This ensures 0/1 from MySQL are treated as true/false in PHP.
     */
    protected $casts = [
        'is_paid' => 'boolean',
        'send_notify' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopePendingNotification($query)
    {
        return $query->where('is_paid', true)->where('send_notify', false);
    }
}