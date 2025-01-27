<?php

namespace App\Filament\Resources\OrderProcessTemplateResource\Pages;

use App\Filament\Resources\OrderProcessTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrderProcessTemplates extends ListRecords
{
    protected static string $resource = OrderProcessTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
