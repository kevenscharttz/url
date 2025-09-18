<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DashboardResource\Pages;
use App\Filament\Resources\DashboardResource\RelationManagers;
use App\Models\Dashboard;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DashboardResource extends Resource
{
    protected static ?string $model = Dashboard::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informações do Dashboard')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('platform')
                            ->options([
                                'powerbi' => 'Power BI',
                                'metabase' => 'Metabase',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('url')
                            ->url()
                            ->required()
                            ->maxLength(65535),
                        Forms\Components\Select::make('visibility')
                            ->options([
                                'public' => 'Público',
                                'private' => 'Privado',
                            ])
                            ->required(),
                        Forms\Components\Select::make('scope')
                            ->options([
                                'organization' => 'Organização',
                                'profile' => 'Perfil',
                                'user' => 'Usuário',
                            ])
                            ->required(),
                        Forms\Components\TagsInput::make('tags'),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Acesso ao Dashboard')
                    ->schema([
                        Forms\Components\Select::make('organizations')
                            ->relationship('organizations', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->dehydrated()
                            ->visible(fn ($operation) => $operation === 'create'),
                        Forms\Components\Select::make('users')
                            ->relationship('users', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->dehydrated()
                            ->visible(fn ($operation) => $operation === 'create'),
                        Forms\Components\Select::make('roles')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->dehydrated()
                            ->visible(fn ($operation) => $operation === 'create'),
                    ])
                    ->visible(fn ($operation) => $operation === 'create')
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('platform')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'powerbi' => 'blue',
                        'metabase' => 'green',
                    }),
                Tables\Columns\TextColumn::make('visibility')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'public' => 'success',
                        'private' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('scope')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'organization' => 'warning',
                        'profile' => 'info',
                        'user' => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('platform')
                    ->options([
                        'powerbi' => 'Power BI',
                        'metabase' => 'Metabase',
                    ]),
                Tables\Filters\SelectFilter::make('visibility')
                    ->options([
                        'public' => 'Público',
                        'private' => 'Privado',
                    ]),
                Tables\Filters\SelectFilter::make('scope')
                    ->options([
                        'organization' => 'Organização',
                        'profile' => 'Perfil',
                        'user' => 'Usuário',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Visualizar')
                    ->url(fn (Dashboard $record) => \App\Filament\Pages\ViewDashboard::getUrl(['dashboard' => $record->id]))
                    ->icon('heroicon-o-eye')
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\OrganizationsRelationManager::class,
            RelationManagers\UsersRelationManager::class,
            RelationManagers\RolesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDashboards::route('/'),
            'create' => Pages\CreateDashboard::route('/create'),
            'edit' => Pages\EditDashboard::route('/{record}/edit'),
        ];
    }
}