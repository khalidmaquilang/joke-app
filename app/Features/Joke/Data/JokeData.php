<?php

namespace App\Features\Joke\Data;

use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class JokeData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public int $id,
        public string $type,
        public string $setup,
        public string $punchline,
    ) {}
}
