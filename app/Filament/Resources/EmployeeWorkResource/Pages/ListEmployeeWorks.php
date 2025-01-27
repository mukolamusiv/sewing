<?php

namespace App\Filament\Resources\EmployeeWorkResource\Pages;

use App\Filament\Resources\EmployeeWorkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeWorks extends ListRecords
{
    protected static string $resource = EmployeeWorkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
