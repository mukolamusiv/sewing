<?php

namespace App\Filament\Resources\MaterialResource\Pages;

use App\Filament\Resources\MaterialResource;
use App\Filament\Resources\MaterialResource\Widgets\StockMaterialWidget;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMaterial extends EditRecord
{
    protected static string $resource = MaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
            StockMaterialWidget::class,
        ];
    }
}
