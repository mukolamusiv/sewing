<?php

namespace App\Filament\Resources\InventoryResource\Pages;

use App\Filament\Resources\InventoryResource;
use App\Models\Warehouse;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListInventories extends ListRecords
{
    protected static string $resource = InventoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
       /* return [
            'Вся продукція' => Tab::make(),
            'active' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('warehouse_id','=', 1)),
        ];*/
        $storage = Warehouse::all();
        $array = [
            'Вся продукція' => Tab::make(),
        ];
        foreach ($storage as $warehouse) {
            $array[$warehouse->name] = Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('warehouse_id','=', $warehouse->id));
        }
        return $array;
    }

    private function setTabs()
    {
        $storage = Warehouse::all();
        $array = [
            'Вся продукція' => Tab::make(),
        ];
        foreach ($storage as $warehouse) {
            $array[$warehouse->name] = Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('warehouse_id','=', $warehouse->id));
        }
        return $array;
    }
}
