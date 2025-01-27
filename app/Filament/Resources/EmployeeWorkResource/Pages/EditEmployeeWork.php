<?php

namespace App\Filament\Resources\EmployeeWorkResource\Pages;

use App\Filament\Resources\EmployeeWorkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeWork extends EditRecord
{
    protected static string $resource = EmployeeWorkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
