<?php

declare(strict_types=1);

namespace App\Features\Joke\Tests\Routes;

use App\Features\Joke\Client\JokeClient;
use App\Features\Token\Models\Token;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class JokesApiTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_returns_jokes_with_valid_token(): void
    {
        $user = User::factory()->create();
        $token = Token::factory()->create(['user_id' => $user->id]);

        $mockJokes = array_map(fn (int $i) => [
            'id' => $i,
            'type' => 'programming',
            'setup' => "Setup $i",
            'punchline' => "Punchline $i",
        ], range(1, 5));

        $jokeClient = $this->createMock(JokeClient::class);
        $jokeClient->expects($this->once())
            ->method('fetchJoke')
            ->willReturn($mockJokes);

        $this->app->instance(JokeClient::class, $jokeClient);

        $response = $this->getJson('/api/v1/jokes', [
            'Authorization' => 'Bearer '.$token->token,
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(3);
        $response->assertJsonStructure([
            '*' => ['id', 'type', 'setup', 'punchline'],
        ]);

        $jokes = $response->json();
        foreach ($jokes as $joke) {
            $this->assertIsInt($joke['id']);
            $this->assertIsString($joke['type']);
            $this->assertIsString($joke['setup']);
            $this->assertIsString($joke['punchline']);
        }
    }

    #[Test]
    public function it_returns_401_when_no_token_is_provided(): void
    {
        $response = $this->getJson('/api/v1/jokes');

        $response->assertStatus(401);
        $response->assertJson([
            'error' => 'No token provided',
        ]);
    }

    #[Test]
    public function it_returns_401_when_invalid_token_is_provided(): void
    {
        $response = $this->getJson('/api/v1/jokes', [
            'Authorization' => 'Bearer invalid-token-that-does-not-exist',
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'error' => 'Invalid token',
        ]);
    }

    #[Test]
    public function it_returns_empty_array_when_joke_client_returns_null(): void
    {
        $user = User::factory()->create();
        $token = Token::factory()->create(['user_id' => $user->id]);

        $jokeClient = $this->createMock(JokeClient::class);
        $jokeClient->expects($this->once())
            ->method('fetchJoke')
            ->willReturn(null);

        $this->app->instance(JokeClient::class, $jokeClient);

        $response = $this->getJson('/api/v1/jokes', [
            'Authorization' => 'Bearer '.$token->token,
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(0);
    }

    #[Test]
    public function it_accepts_token_from_bearer_authorization_header(): void
    {
        $user = User::factory()->create();
        $token = Token::factory()->create(['user_id' => $user->id]);

        $mockJokes = array_map(fn (int $i) => [
            'id' => $i,
            'type' => 'programming',
            'setup' => "Setup $i",
            'punchline' => "Punchline $i",
        ], range(1, 3));

        $jokeClient = $this->createMock(JokeClient::class);
        $jokeClient->expects($this->once())
            ->method('fetchJoke')
            ->willReturn($mockJokes);

        $this->app->instance(JokeClient::class, $jokeClient);

        $response = $this->withHeader('Authorization', 'Bearer '.$token->token)
            ->getJson('/api/v1/jokes');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }
}
