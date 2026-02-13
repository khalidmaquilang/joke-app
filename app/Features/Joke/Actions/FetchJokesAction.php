<?php

namespace App\Features\Joke\Actions;

use App\Features\Joke\Client\JokeClient;
use App\Features\Joke\Data\JokeData;
use Illuminate\Support\Arr;

class FetchJokesAction
{
    public function __construct(protected JokeClient $joke_client) {}

    /**
     * @return array<int, JokeData>
     */
    public function handle(): array
    {
        $jokes = $this->joke_client->fetchJoke();
        if ($jokes === null) {
            return [];
        }

        $random_jokes = Arr::random($jokes, 3);

        return JokeData::collect($random_jokes);
    }
}
