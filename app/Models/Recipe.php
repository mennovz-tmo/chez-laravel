<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description_short', 'allergens', 'price', 'picture'
    ];

    protected function casts(): array
    {
        return [
            'allergens' => 'array',
            'price' => 'decimal:2',
        ];
    }
}
