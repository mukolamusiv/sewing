{{-- filepath: /f:/OSPanel/home/sewing/resources/views/filament/resources/order-resource/widgets/total-cost-widget.blade.php --}}
<x-filament::widget>
    <x-filament::card>
        <h2>Загальна сума</h2>
        <p>{{ $this->getTotalCost() }}</p>
    </x-filament::card>
</x-filament::widget>
