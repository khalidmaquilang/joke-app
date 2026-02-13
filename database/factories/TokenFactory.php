<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Features\Token\Models\Token;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @extends Factory<Token>
 */
class TokenFactory extends Factory
{
    protected $model = Token::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->word(),
            'token' => Str::random(50),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->state([])->afterMaking(function (Token $token): void {
            // Set required attributes to bypass the creating event
        });
    }

    /**
     * Create instance with all model events disabled.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function create($attributes = [], ?Model $parent = null): Model
    {
        return Token::withoutEvents(function () use ($attributes, $parent) {
            return parent::create($attributes, $parent);
        });
    }
}
