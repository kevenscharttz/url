<?php

namespace App\Filament\Resources\Dashboards\Pages;

use App\Filament\Resources\Dashboards\DashboardResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Models\Dashboard;
use Illuminate\Support\Facades\Auth;
// ...existing code...

class ListDashboards extends ListRecords
{
    protected static string $resource = DashboardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    // Use Filament's default table listing (no custom content override)

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
    $user = Auth::user();

    return Dashboard::query()->visibleTo($user);
    }
}
