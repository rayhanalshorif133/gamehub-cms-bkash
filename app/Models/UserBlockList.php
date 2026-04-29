<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBlockList extends Model
{
    use HasFactory;

    protected $table = 'user_block_list';

    protected $fillable = [
        'campaign_id',
        'msisdn',
        'message',
        'block_type',
        'block_reason',
        'is_blocked',
        'is_read',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_blocked' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Campaign এর সাথে রিলেশন (BelongsTo)
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
}