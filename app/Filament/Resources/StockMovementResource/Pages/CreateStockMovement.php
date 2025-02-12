<?php

namespace App\Filament\Resources\StockMovementResource\Pages;

use App\Filament\Resources\StockMovementResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStockMovement extends CreateRecord
{
    protected static string $resource = StockMovementResource::class;


    public function create(bool $another = false): void
    {
        dd($this->data);
        parent::create($another);


       // dd($another,$this->record->id,$template->processes);
        // Додатковий код після створення замовлення
    }
}
