<?php

namespace App\Filament\Resources\MaterialOrderTemplateResource\Pages;

use App\Filament\Resources\MaterialOrderTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMaterialOrderTemplate extends EditRecord
{
    protected static string $resource = MaterialOrderTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
