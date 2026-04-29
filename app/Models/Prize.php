<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    use HasFactory;

   
    protected $table = 'prizes';

   
    protected $fillable = [
        'title',
        'total_amount',
        'description',
    ];

    
    public function distributions()
    {
        return $this->hasMany(PrizeDistribution::class, 'prize_id');
    }

   
    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'prize_id');
    }
}