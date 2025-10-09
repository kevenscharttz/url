<?php




namespace App\Filament\Resources\Organizations\Schemas;
use Illuminate\Support\Str;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Get;
use Filament\Schemas\Schema;
use App\Models\User;

class OrganizationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->unique(table: 'organizations', column: 'name', ignoreRecord: true)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->label('Slug')
                    ->disabled()
                    ->unique(table: 'organizations', column: 'slug', ignoreRecord: true)
                    ->dehydrated(),
                Textarea::make('description')
                    ->label('Descrição')
                    ->columnSpanFull(),
                Select::make('users')
                    ->label('Usuários')
                    ->relationship('users', 'name')
                    ->multiple()
                    ->preload()
                    ->columnSpanFull(),
            ]);
    }
}
