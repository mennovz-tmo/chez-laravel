<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'description_short', 'allergens', 'price', 'picture'])]
class Recipe extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'allergens' => 'array',
            'price' => 'decimal:2',
        ];
    }
}
