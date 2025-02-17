<?php

namespace App\Filament\Resources\MaterialOrderTemplateResource\Pages;

use App\Filament\Resources\MaterialOrderTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMaterialOrderTemplates extends ListRecords
{
    protected static string $resource = MaterialOrderTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
