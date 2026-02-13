<?php

namespace App\Filament\Resources\Tokens;

use App\Features\Token\Models\Token;
use App\Filament\Resources\Tokens\Pages\CreateToken;
use App\Filament\Resources\Tokens\Pages\EditToken;
use App\Filament\Resources\Tokens\Pages\ListTokens;
use App\Filament\Resources\Tokens\Schemas\TokenForm;
use App\Filament\Resources\Tokens\Tables\TokensTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TokenResource extends Resource
{
    protected static ?string $model = Token::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Key;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return TokenForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TokensTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTokens::route('/'),
            'create' => CreateToken::route('/create'),
            'edit' => EditToken::route('/{record}/edit'),
        ];
    }
}
