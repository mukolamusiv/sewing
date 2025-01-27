<?php

namespace App\Filament\Resources\OrderProcessTemplateResource\Pages;

use App\Filament\Resources\OrderProcessTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrderProcessTemplate extends EditRecord
{
    protected static string $resource = OrderProcessTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
