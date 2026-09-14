<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklySchedule extends Model
{
    use HasFactory;

    protected $fillable = ['day_of_week', 'is_open', 'opening', 'closing'];

    protected $casts = [
        'day_of_week' => 'integer',
        'is_open' => 'boolean',
        'opening' => 'datetime:H:i',
        'closing' => 'datetime:H:i',
    ];
}
