<?php

namespace App\Features\Token\Models;

use App\Features\Shared\Enums\ModeEnum;
use App\Features\Shared\Helpers\MerchantResolver;
use App\Features\Shared\Livewire\ModeSwitcher\Helpers\ModeSwitchHelper;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Token extends Model
{
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
