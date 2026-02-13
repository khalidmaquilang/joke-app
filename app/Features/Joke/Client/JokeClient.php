<?php

namespace App\Features\Joke\Client;

use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class JokeClient
{
    /**
     * @return array<int, mixed>|null
     */
    public function fetchJoke(): ?array
    {
        try {
            $response = Http::timeout(30)
                ->get('https://official-joke-api.appspot.com/jokes/programming/ten');
        } catch (ConnectionException $exception) {
            throw new Exception($exception->getMessage());
        }

        return $response->json();
    }
}
