<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\Widget;

class CurrentProcessStageWidget extends Widget
{
    protected static string $view = 'filament.resources.order-resource.widgets.current-process-stage-widget';

    public $order;

    public function mount($orderId)
{
    $this->order = Order::find($orderId);

    if (!$this->order) {
        throw new \Exception("Order not found!");
    }
}

    public function getCurrentStage()
    {
        return $this->order->process()->latest()->first()->step ?? 'Немає етапів';
    }
}
