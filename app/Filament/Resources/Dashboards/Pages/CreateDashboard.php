<?php

namespace App\Filament\Resources\Dashboards\Pages;

use App\Filament\Resources\Dashboards\DashboardResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;
use App\Models\Dashboard;

class CreateDashboard extends CreateRecord
{
    protected static string $resource = DashboardResource::class;

    protected function beforeCreate(array $data): void
    {
        // Enforce uniqueness per scope
        if (! empty($data['organization_id'])) {
            $exists = Dashboard::where('organization_id', $data['organization_id'])->exists();
            if ($exists) {
                throw ValidationException::withMessages(['organization_id' => 'Já existe um Dashboard para essa organização.']);
            }
        }

        if (! empty($data['scope_profile_id'])) {
            $exists = Dashboard::where('scope_profile_id', $data['scope_profile_id'])->exists();
            if ($exists) {
                throw ValidationException::withMessages(['scope_profile_id' => 'Já existe um Dashboard para esse perfil.']);
            }
        }

        if (! empty($data['scope_user_id'])) {
            $exists = Dashboard::where('scope_user_id', $data['scope_user_id'])->exists();
            if ($exists) {
                throw ValidationException::withMessages(['scope_user_id' => 'Já existe um Dashboard para esse usuário.']);
            }
        }
    }
}
