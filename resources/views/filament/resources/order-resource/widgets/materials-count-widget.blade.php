{{-- filepath: /f:/OSPanel/home/sewing/resources/views/filament/resources/order-resource/widgets/materials-count-widget.blade.php --}}
<x-filament::widget>
    <x-filament::card>
        <h2>Кількість матеріалів</h2>
        <p>{{ $this->getMaterialsCount() }}</p>
    </x-filament::card>
</x-filament::widget>
