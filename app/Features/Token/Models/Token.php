<?php

namespace App\Features\Token\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Token extends Model
{
    use HasFactory;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): \Illuminate\Database\Eloquent\Factories\Factory
    {
        return \Database\Factories\TokenFactory::new();
    }

    protected static function booted(): void
    {
        static::creating(function (Token $token): void {
            /** @var User|null $user */
            $user = auth()->user();
            if ($user === null || ! $user->id) {
                abort(500);
            }

            $token->user_id = $user->id;
            $token->token = Str::random(50);
        });
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
