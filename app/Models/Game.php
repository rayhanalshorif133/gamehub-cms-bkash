<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;


    protected $table = 'games'; // Explicitly define the table if it's different from the plural of the model name

    protected $fillable = [
        'title',
        'banner',
        'description',
        'attempt',
        'keyword',
        'card_bg_image',
        'bg_color',
        'icon',
        'url',
        'status'
    ];


    // Optionally, you can define the dates for the created_at and updated_at columns
    protected $dates = [
        'created_at',
        'updated_at',
    ];


    public function incrementAttempt()
    {
        $this->attempt = intval($this->attempt) + 1;
        $this->save();
    }
}
