<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;

//use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use App\Models\Wallet;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make('createWallet')
            //     ->label('Add Wallet')
            //     ->form([
            //         Actions\Forms\Components\TextInput::make('name')
            //             ->required()
            //             ->label('Wallet Name'),
            //         Actions\Forms\Components\TextInput::make('description')
            //             ->label('Description'),
            //         Actions\Forms\Components\TextInput::make('amount')
            //             ->numeric()
            //             ->required()
            //             ->label('Initial Amount'),
            //     ]),

            \Filament\Actions\Action::make('add_wallet')
            ->label('Додати гаманець')
            ->icon('heroicon-o-wallet')
            ->modalHeading('Створення нового гаманця')
            ->modalButton('Створити')
            ->form([
                TextInput::make('name')
                    ->label('Назва гаманця')
                    ->required(),

                TextInput::make('description')
                    ->label('Опис гаманця'),


                TextInput::make('amount')
                    ->label('Початковий баланс')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ])
            ->action(function (array $data) {
                Wallet::create($data);

                Notification::make()
                    ->title('Гаманець створено!')
                    ->success()
                    ->send();
            }),
            Actions\CreateAction::make(),
            Actions\Action::make('refresh')
                ->label('Оновити сторінку')
                //->icon('heroicon-o-refresh')
                ->action(function () {
                    $this->refresh();
                }),
        ];
    }

    public function refresh()
    {
        //dd('refresh');
        $this->redirect($this
            ->request
            ->url()
            ->current());
    }
}
