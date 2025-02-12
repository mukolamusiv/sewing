<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\Widget;

class TotalCostWidget extends Widget
{
    protected static string $view = 'filament.resources.order-resource.widgets.total-cost-widget';

    public $order;

    public function mount(Order $order)
    {
        $this->order = $order;
    }

    public function getTotalCost()
    {
        return $this->order->total_cost;
    }
}
