{{-- filepath: /f:/OSPanel/home/sewing/resources/views/filament/resources/order-resource/widgets/current-process-stage-widget.blade.php --}}
<x-filament::widget>
    <x-filament::card>
        <h2>Актуальний етап виробництва</h2>
        <p>{{ $this->getCurrentStage() }}</p>
    </x-filament::card>
</x-filament::widget>
