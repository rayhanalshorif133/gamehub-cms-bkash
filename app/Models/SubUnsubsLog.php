<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubUnsubsLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'msisdn',
        'subscription_id',
        'payment_id',
        'type',
        'keyword',
        'status',
        'message',
        'date',
    ];


}
