<?php

namespace App\Filament\Resources\Dashboards\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Get;
use Filament\Schemas\Schema;
use App\Models\Organization;

class DashboardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->unique(table: 'dashboards', column: 'title', ignoreRecord: true),
                Select::make('organization_id')
                    ->label('Organização')
                    ->options(Organization::pluck('name', 'id'))
                    ->required(),
                Select::make('platform')
                    ->label('Plataforma')
                    ->options([
                        'Power BI' => 'Power BI',
                        'Metabase' => 'Metabase',
                    ])
                    ->required()
                    ->searchable(),
                TextInput::make('url')
                    ->label('URL')
                    ->required()
                    ->url()
                    ->placeholder('https://...'),
                Select::make('visibility')
                    ->label('Visibilidade')
                    ->options([
                        'public' => 'Público',
                        'private' => 'Privado',
                    ])
                    ->required(),
                TagsInput::make('tags')
                    ->label('Tags')
                    ->placeholder('Adicione tags'),
                Placeholder::make('preview')
                    ->label('Pré-visualização')
                    ->content(fn ($record) => $record && $record->url ? '<iframe src="' . e($record->url) . '" sandbox="allow-scripts allow-same-origin" style="width:100%;height:400px;border:1px solid #ccc;"></iframe>' : '')
                    ->visible(fn ($record) => filled($record?->url))
                    ->columnSpanFull()
                    ->extraAttributes(['style' => 'margin-top:2rem;'])
                    ->html(),
            ]);
    }
}
