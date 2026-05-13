<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boost extends Model
{
    use HasFactory;

    protected $table = 'boosts';


    protected $fillable = [
        'name',
        'desc',
        'type',
        'amount',
        'score_up',
        'validity',
        'status',
    ];



}
