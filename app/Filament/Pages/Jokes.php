<?php

namespace App\Filament\Pages;

use App\Features\Joke\Actions\FetchJokesAction;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class Jokes extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Megaphone;

    protected string $view = 'filament.pages.jokes';

    protected FetchJokesAction $fetch_jokes_action;

    public array $jokes = [
        ['type' => 'programming', 'setup' => 'Why did the programmer always carry a pencil?', 'punchline' => 'They preferred to write in C#.', 'id' => 448],
        ['type' => 'programming', 'setup' => 'Which song would an exception sing?', 'punchline' => "Can't catch me - Avicii", 'id' => 32],
        ['type' => 'programming', 'setup' => 'Why did the private classes break up?', 'punchline' => 'Because they never saw each other.', 'id' => 407],
        ['type' => 'programming', 'setup' => "Why don't React developers like nature?", 'punchline' => 'They prefer the virtual DOM.', 'id' => 411],
        ['type' => 'programming', 'setup' => "Why dot net developers don't wear glasses?", 'punchline' => 'Because they see sharp.', 'id' => 376],
        ['type' => 'programming', 'setup' => 'How many React developers does it take to change a lightbulb?', 'punchline' => 'None, they prefer dark mode.', 'id' => 410],
        ['type' => 'programming', 'setup' => "What's the best thing about a Boolean?", 'punchline' => "Even if you're wrong, you're only off by a bit.", 'id' => 15],
        ['type' => 'programming', 'setup' => 'There are 10 types of people in this world...', 'punchline' => "Those who understand binary and those who don't", 'id' => 28],
        ['type' => 'programming', 'setup' => 'Where did the API go to eat?', 'punchline' => 'To the RESTaurant.', 'id' => 390],
        ['type' => 'programming', 'setup' => 'How many programmers does it take to change a lightbulb?', 'punchline' => "None that's a hardware problem", 'id' => 24],
    ];

    public function boot(FetchJokesAction $fetch_jokes_action): void
    {
        $this->fetch_jokes_action = $fetch_jokes_action;
    }

    public function mount(): void
    {
        $this->jokes = $this->fetch_jokes_action->handle();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('refresh_joke')
                ->action(function () {
                    $this->mount();
                }),
        ];
    }
}
