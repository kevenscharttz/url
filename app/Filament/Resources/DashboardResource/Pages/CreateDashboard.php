<?php

namespace App\Filament\Resources\DashboardResource\Pages;

use App\Filament\Resources\DashboardResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;


class CreateDashboard extends CreateRecord
{
    protected static string $resource = DashboardResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Validação de unicidade por escopo
        $scope = $data['scope'] ?? null;
        if ($scope === 'organization' && isset($data['organizations'])) {
            foreach ($data['organizations'] as $orgId) {
                $exists = \App\Models\Dashboard::where('scope', 'organization')
                    ->whereHas('organizations', fn($q) => $q->where('organizations.id', $orgId))
                    ->exists();
                if ($exists) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'organizations' => 'Já existe um dashboard para esta organização.'
                    ]);
                }
            }
        }
        if ($scope === 'profile' && isset($data['roles'])) {
            foreach ($data['roles'] as $roleId) {
                $exists = \App\Models\Dashboard::where('scope', 'profile')
                    ->whereHas('roles', fn($q) => $q->where('roles.id', $roleId))
                    ->exists();
                if ($exists) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'roles' => 'Já existe um dashboard para este perfil.'
                    ]);
                }
            }
        }
        if ($scope === 'user' && isset($data['users'])) {
            foreach ($data['users'] as $userId) {
                $exists = \App\Models\Dashboard::where('scope', 'user')
                    ->whereHas('users', fn($q) => $q->where('users.id', $userId))
                    ->exists();
                if ($exists) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'users' => 'Já existe um dashboard para este usuário.'
                    ]);
                }
            }
        }
        return $data;
    }
}
