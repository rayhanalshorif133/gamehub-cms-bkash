<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubsLog extends Model
{
    use HasFactory;
    protected $table = 'subs_logs';

    protected $fillable = [
        'msisdn',
        'subscription_id',
        'payment_id',
        'type',
        'keyword',
        'status',
        'amount',
        'message',
        'date',
        'response',
    ];

    protected $casts = [
        'date' => 'date',
        'response' => 'array',
    ];
}
