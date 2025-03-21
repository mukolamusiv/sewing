<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\Widget;

class MaterialsCountWidget extends Widget
{
    protected static string $view = 'filament.resources.order-resource.widgets.materials-count-widget';

    public $order;

    public function mount($orderId)
    {
        $this->order = Order::find($orderId);

        if (!$this->order) {
            throw new \Exception("Order not found!");
        }
    }

    public function getMaterialsCount()
    {
        return $this->order->materials()->count();
    }
}
