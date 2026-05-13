<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Campaign extends Model
{
    use HasFactory;


    protected $table = 'campaigns'; // Explicitly define the table if it's different from the plural of the model name

    protected $fillable = [
        'name',
        'banner',
        'game_id',
        'prize_id',
        'game_keyword',
        'amount',
        'gift_amount',
        'participation',
        'subs_validity',
        'prize_description',
        'score_count_type',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'status',
        'description',
        'time_status',
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
    ];


    public function getTimeForCampaignAttribute()
    {
        return $this->calculateTimeForCampaign($this);
    }


    public function incrementParticipation()
    {
        $this->participation = intval($this->participation) + 1;
        $this->save();
    }

    public function levels()
    {
        return $this->hasMany(CampaignLevel::class);
    }


    public function calculateTimeForCampaign($campaign)
    {
        $start = Carbon::parse($campaign->start_date)->setTimeFromTimeString($campaign->start_time);
        $end   = Carbon::parse($campaign->end_date)->setTimeFromTimeString($campaign->end_time);
        $now   = now();

        if ($now->gt($start) && $now->lt($end)) {
            $campaign->time_status = 'End in';

            $remaining = $now->diff($end);
            $campaign->day_left   = $remaining->format('%a');
            $campaign->time_h_left = $remaining->format('%H');
            $campaign->time_m_left = $remaining->format('%I');
        } elseif ($now->lt($start)) {
            $campaign->time_status = 'Upcoming';

            $remaining = $now->diff($start);
            $campaign->day_left   = $remaining->format('%a');
            $campaign->time_h_left = $remaining->format('%H');
            $campaign->time_m_left = $remaining->format('%I');
        } else {
            $campaign->time_status = 'Expired';

            $remaining = $end->diff($now);
            $campaign->day_left   = $remaining->format('%a');
            $campaign->time_h_left = $remaining->format('%H');
            $campaign->time_m_left = $remaining->format('%I');
        }

        return $campaign;
    }
}
