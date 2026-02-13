<?php

namespace App\Features\Joke\Client;

use App\Features\Shared\PaymentGateway\Enums\PaymentErrorCodeEnum;
use App\Features\Shared\PaymentGateway\Exceptions\PaymentFailedException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Exception;

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