<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\Widget;

class MaterialsCountWidget extends Widget
{
    protected static string $view = 'filament.resources.order-resource.widgets.materials-count-widget';

    public $order;

    public function mount(Order $order)
    {
        $this->order = $order;
    }

    public function getMaterialsCount()
    {
        return $this->order->materials()->count();
    }
}
