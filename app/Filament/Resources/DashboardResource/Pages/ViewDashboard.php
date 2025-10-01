<?php

namespace App\Filament\Resources\DashboardResource\Pages;

use App\Filament\Resources\DashboardResource;
use Filament\Resources\Pages\Page;
use App\Models\Dashboard;

class ViewDashboard extends Page
{
    protected static string $resource = DashboardResource::class;
    protected static string $view = 'filament.resources.dashboard-resource.pages.view-dashboard';

    public Dashboard $record;

    public function mount($record): void
    {
        // O Filament já injeta o modelo Dashboard em $record
        $this->record = is_array($record) ? new Dashboard($record) : $record;
    }

    public function getTitle(): string
    {
        return $this->record->name;
    }

    public function getViewData(): array
    {
        return [
            'dashboard' => $this->record,
        ];
    }
}
