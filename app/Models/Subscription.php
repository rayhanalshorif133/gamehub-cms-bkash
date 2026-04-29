<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'msisdn',
        'payment_id',
        'keyword',
        'subs_date',
        'status',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

}
