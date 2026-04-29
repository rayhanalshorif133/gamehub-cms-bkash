<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BkashAuthLog extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'bkash_auth_logs';

    // The attributes that are mass assignable.
    protected $fillable = [
        'mobile_number',
        'id_token',
        'created_date',
        'created_time',
        'exp_time',
    ];

    // Optionally, you can define hidden attributes
    // protected $hidden = ['id_token'];

    // If you want to manage the date fields
    protected $dates = [
        'created_date',
    ];
}
