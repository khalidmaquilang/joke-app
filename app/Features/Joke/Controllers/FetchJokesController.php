<?php

namespace App\Features\Joke\Controllers;

use App\Features\Joke\Actions\FetchJokesAction;
use App\Features\Joke\Data\JokeData;
use App\Http\Controllers\Controller;

class FetchJokesController extends Controller
{
    public function __construct(protected FetchJokesAction $fetch_jokes_action) {}

    /**
     * @return array<int, JokeData>
     */
    public function __invoke(): array
    {
        return $this->fetch_jokes_action->handle();
    }
}
