<?php

namespace App\Filament\Resources\MaterialResource\Widgets;

use App\Models\Material;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StockMaterialWidget extends BaseWidget
{

    public $material;

    private $count_materials;

    private $record;

    public function mount($record)
    {
        $this->record = $record;
        $this->count_materials = 0;
        $this->material = Material::find($record)->last();
        //$this->calculate($record);
    }

    private function calculate($record)
    {
        //$this->material = Material::find($record)->last();
        foreach ($this->material->inventories as $inventory) {
            $this->count_materials += $inventory->quantity;
        }
        //dd($this->material->inventories);
    }

    protected function getStats(): array
    {
        $this->calculate($this->record);
        return [
             Stat::make('Ціна за одиницю', $this->material->unit_cost.' грн'),
             Stat::make('Кількість на усіх складах', $this->count_materials. 'одиниць'),
             Stat::make('Вартість продукції на складах', $this->count_materials*$this->material->unit_cost.' грн'),
        ];
    }
}
