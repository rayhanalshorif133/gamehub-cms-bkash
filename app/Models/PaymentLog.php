<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    use HasFactory;

    protected $table = 'payment_logs';


    protected $fillable = [
        'campaign_id',
        'status',
        'msg',
        'msisdn',
        'amount',
        'payment_id',
        'date',
    ];

}
