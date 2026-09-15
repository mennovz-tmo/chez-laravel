<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpeningDatetime extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'open', 'opening', 'closing'];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'open' => 'boolean',
        'opening' => 'datetime:H:i',
        'closing' => 'datetime:H:i',
    ];
}
