<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasBoost extends Model
{
    use HasFactory;

    protected $table = 'user_has_boosts';

    protected $fillable = [
        'msisdn',
        'keyword',
        'camp_id',
        'boost_id',
        'validity',
        'start_time',
        'expire_time',
        'date'
    ];




    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    /**
     * Scope: Active Boost (current time + date check)
     */
    public function scopeActive($query)
    {
        $now = now();

        return $query->whereDate('date', $now->toDateString())
                     ->whereTime('start_time', '<=', $now->format('H:i:s'))
                     ->whereTime('end_time', '>=', $now->format('H:i:s'));
    }

    /**
     * Relation: Campaign
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'camp_id');
    }

    /**
     * Relation: Boost
     */
    public function boost()
    {
        return $this->belongsTo(Boost::class, 'boost_id');
    }

    /**
     * Accessor: Full Time Range
     */
    public function getTimeRangeAttribute()
    {
        return $this->start_time . ' - ' . $this->end_time;
    }
}
