<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informações do Perfil')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('scope')
                            ->options([
                                'global' => 'Global',
                                'organization' => 'Organização',
                            ])
                            ->required(),
                    ]),
                
                Forms\Components\Section::make('Vínculos')
                    ->schema([
                        Forms\Components\Select::make('users')
                            ->relationship('users', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->dehydrated()
                            ->visible(fn ($operation) => $operation === 'create'),
                        Forms\Components\Select::make('organizations')
                            ->relationship('organizations', 'name')
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
                Tables\Columns\TextColumn::make('scope')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'global' => 'success',
                        'organization' => 'warning',
                    }),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('scope')
                    ->options([
                        'global' => 'Global',
                        'organization' => 'Organização',
                    ]),
            ])
            ->actions([
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
            RelationManagers\UsersRelationManager::class,
            RelationManagers\OrganizationsRelationManager::class,
            RelationManagers\DashboardsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}