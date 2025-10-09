<?php

namespace App\Filament\Resources\Dashboards\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\View;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DashboardInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title')
                    ->label('Título'),
                TextEntry::make('organization.name')
                    ->label('Organização'),
                TextEntry::make('platform')
                    ->label('Plataforma'),
                TextEntry::make('url')
                    ->label('URL'),
                TextEntry::make('visibility')
                    ->label('Visibilidade'),
                TextEntry::make('tags')
                    ->label('Tags')
                    ->placeholder('-')
                    ->columnSpanFull(),
                Section::make('Preview')
                    ->schema([
                        View::make('filament.dashboards.preview'),
                    ])
                    ->columnSpanFull()
                    ->visible(fn ($record) => filled($record?->url)),
                TextEntry::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
