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

    public array $jokes = [];

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
