<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrizeDistribution extends Model
{
    use HasFactory;

    // Table name jodi plural hoy (prize_distributions), tobe Laravel auto dhore nibe.
    // Kintu explicitly niche bole deya bhalo:
    protected $table = 'prize_distributions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prize_id',
        'rank_min',
        'rank_max',
        'amount',
        'prize_level',
    ];

    /**
     * Get the prize that owns the distribution.
     * Ei distribution kon prize pool-er under-e seta janar jonno.
     */
    public function prize()
    {
        return $this->belongsTo(Prize::class, 'prize_id');
    }
}