<?php

use App\Features\Joke\Controllers\FetchJokesController;
use App\Features\Token\Middlewares\ValidateUserToken;

Route::get('/jokes', FetchJokesController::class)
    ->middleware(ValidateUserToken::class);
