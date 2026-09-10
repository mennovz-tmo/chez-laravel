<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable('name', 'amount_of_people', 'phone_number', 'email', 'comment', 'date', 'arrival', 'departure')]
class Reservation extends Model
{
    use HasFactory;

    /**
     * The delete token hash must never be exposed via arrays/JSON.
     *
     * @var list<string>
     */
    protected $hidden = ['delete_token'];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'delete_token_expires_at' => 'datetime',
        ];
    }

    /**
     * Generate a new delete token, store only its hash + expiry, and
     * return the plaintext token so it can be e-mailed.
     */
    public function generateDeleteToken(): string
    {
        $plainToken = Str::random(64);

        $this->forceFill([
            'delete_token' => hash('sha256', $plainToken),
            'delete_token_expires_at' => now()->addDay(),
        ])->save();

        return $plainToken;
    }

    /**
     * Check a plaintext token against the stored hash and expiry.
     */
    public function hasValidDeleteToken(?string $plainToken): bool
    {
        if (empty($plainToken) || empty($this->delete_token) || empty($this->delete_token_expires_at)) {
            return false;
        }

        if ($this->delete_token_expires_at->isPast()) {
            return false;
        }

        return hash_equals($this->delete_token, hash('sha256', $plainToken));
    }

    /**
     * Invalidate the pending delete token.
     */
    public function clearDeleteToken(): void
    {
        $this->forceFill([
            'delete_token' => null,
            'delete_token_expires_at' => null,
        ])->save();
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->number)) {
                $model->number = generate_reservation_number();
            }
        });
    }
}
