<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\Widget;

class TotalCostWidget extends Widget
{
    protected static string $view = 'filament.resources.order-resource.widgets.total-cost-widget';

    public $order;

    public function mount($orderId)
    {
        $this->order = Order::find($orderId);

        if (!$this->order) {
            throw new \Exception("Order not found!");
        }
    }



    public function getTotalCost()
    {
       // $this->order->getTotalCost;
        return $this->order->getTotalCost();
    }
}
