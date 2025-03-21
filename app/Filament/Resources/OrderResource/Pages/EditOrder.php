<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Filament\Resources\OrderResource\Widgets\CurrentProcessStageWidget;
use App\Filament\Resources\OrderResource\Widgets\MaterialsCountWidget;
use App\Filament\Resources\OrderResource\Widgets\TotalCostWidget;
use App\Filament\Resources\OrderResource\Widgets\TotlaCost;
use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Torgodly\Html2Media\Actions\Html2MediaAction;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [

            // Html2MediaAction::make('print')
            //     ->label('Згенерувати PDF')
            //     ->action('pdf'),

             Actions\Action::make('Завантажити PDF')
             //Action::make('Завантажити PDF')
                //->icon('heroicon-o-document-download')
                ->color('primary')
                ->label('PDF')
                ->requiresConfirmation() // Підтвердження перед генерацією
                ->action(function (Order $record) {
                    return redirect()->route('order.pdf', ['order' => $record->id]);
                }),
                //->action(fn (Order $record) => self::generatePdf($record))
                //->openUrlInNewTab(fn (Order $record) => route('order.pdf', $record->id)),
            //     ->label('Згенерувати звіт')
            //     ->action('pdf'),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    public function pdf()
    {
        $record = $this->record;

        // Html2MediaAction::make('print')
        //     ->scale(2)
        //     //->print() // Enable print option
        //     //->preview() // Enable preview option
        //     ->filename('invoice') // Custom file name
        //     ->savePdf('test.pdf') // Enable save as PDF option
        //     ->requiresConfirmation() // Show confirmation modal
        //     //->pagebreak('section', ['css', 'legacy'])
        //     ->orientation('portrait') // Portrait orientation
        //     ->format('a4', 'mm') // A4 format with mm units
        //     ->enableLinks() // Enable links in PDF
        //     ->margin([0, 50, 0, 50]) // Set custom margins
        //     ->content(fn($record) => view('demopdf', ['order' => $record]));

            Html2MediaAction::make('print')
            ->filename('my-custom-document')
            ->savePdf()
            ->print(true)
            ->content(fn($record) => view('demopdf', ['order' => $record]));
        //$this->notify('Custom function ran successfully!');
    }

    public function getHeaderWidgets(): array
    {

        return [
            //TotlaCost::class,
            CurrentProcessStageWidget::make(['orderId' => request()->route('record')]),
            MaterialsCountWidget::make(['orderId' => request()->route('record')]),
            TotalCostWidget::make(['orderId' => request()->route('record')]),
        ];
    }
}
