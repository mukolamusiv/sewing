<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Filament\Resources\OrderResource\Widgets\CurrentProcessStageWidget;
use App\Filament\Resources\OrderResource\Widgets\MaterialsCountWidget;
use App\Filament\Resources\OrderResource\Widgets\TotalCostWidget;
use App\Filament\Resources\OrderResource\Widgets\TotlaCost;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

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
            //TotlaCost::class,
            CurrentProcessStageWidget::class,
            MaterialsCountWidget::class,
            TotalCostWidget::class,
        ];
    }
}
