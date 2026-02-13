<?php

declare(strict_types=1);

namespace App\Features\Joke\Tests\Actions;

use App\Features\Joke\Actions\FetchJokesAction;
use App\Features\Joke\Client\JokeClient;
use App\Features\Joke\Data\JokeData;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FetchJokesActionTest extends TestCase
{
    #[Test]
    public function it_returns_three_random_jokes_when_client_returns_valid_data(): void
    {
        $mockJokes = [
            ['id' => 1, 'type' => 'programming', 'setup' => 'Setup 1', 'punchline' => 'Punchline 1'],
            ['id' => 2, 'type' => 'programming', 'setup' => 'Setup 2', 'punchline' => 'Punchline 2'],
            ['id' => 3, 'type' => 'programming', 'setup' => 'Setup 3', 'punchline' => 'Punchline 3'],
            ['id' => 4, 'type' => 'programming', 'setup' => 'Setup 4', 'punchline' => 'Punchline 4'],
            ['id' => 5, 'type' => 'programming', 'setup' => 'Setup 5', 'punchline' => 'Punchline 5'],
        ];

        $jokeClient = $this->createMock(JokeClient::class);
        $jokeClient->expects($this->once())
            ->method('fetchJoke')
            ->willReturn($mockJokes);

        $action = new FetchJokesAction($jokeClient);
        $result = $action->handle();

        $this->assertIsArray($result);
        $this->assertCount(3, $result);

        foreach ($result as $joke) {
            $this->assertInstanceOf(JokeData::class, $joke);
            $this->assertIsInt($joke->id);
            $this->assertIsString($joke->type);
            $this->assertIsString($joke->setup);
            $this->assertIsString($joke->punchline);
        }
    }

    #[Test]
    public function it_returns_empty_array_when_client_returns_null(): void
    {
        $jokeClient = $this->createMock(JokeClient::class);
        $jokeClient->expects($this->once())
            ->method('fetchJoke')
            ->willReturn(null);

        $action = new FetchJokesAction($jokeClient);
        $result = $action->handle();

        $this->assertIsArray($result);
        $this->assertCount(0, $result);
    }

    #[Test]
    public function it_returns_all_jokes_when_client_returns_fewer_than_three(): void
    {
        $mockJokes = [
            ['id' => 1, 'type' => 'programming', 'setup' => 'Setup 1', 'punchline' => 'Punchline 1'],
            ['id' => 2, 'type' => 'programming', 'setup' => 'Setup 2', 'punchline' => 'Punchline 2'],
            ['id' => 3, 'type' => 'programming', 'setup' => 'Setup 3', 'punchline' => 'Punchline 3'],
        ];

        $jokeClient = $this->createMock(JokeClient::class);
        $jokeClient->expects($this->once())
            ->method('fetchJoke')
            ->willReturn($mockJokes);

        $action = new FetchJokesAction($jokeClient);
        $result = $action->handle();

        $this->assertIsArray($result);
        $this->assertCount(3, $result);

        foreach ($result as $joke) {
            $this->assertInstanceOf(JokeData::class, $joke);
        }
    }

    #[Test]
    public function it_returns_exactly_three_jokes_when_client_returns_more_than_three(): void
    {
        $mockJokes = array_map(fn (int $i) => [
            'id' => $i,
            'type' => 'programming',
            'setup' => "Setup $i",
            'punchline' => "Punchline $i",
        ], range(1, 10));

        $jokeClient = $this->createMock(JokeClient::class);
        $jokeClient->expects($this->once())
            ->method('fetchJoke')
            ->willReturn($mockJokes);

        $action = new FetchJokesAction($jokeClient);
        $result = $action->handle();

        $this->assertIsArray($result);
        $this->assertCount(3, $result);

        $returnedIds = array_map(fn (JokeData $joke) => $joke->id, $result);
        foreach ($returnedIds as $id) {
            $this->assertContains($id, range(1, 10));
        }
    }
}
