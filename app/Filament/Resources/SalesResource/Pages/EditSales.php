<?php

namespace App\Filament\Resources\SalesResource\Pages;

use App\Filament\Resources\SalesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

use Filament\Forms;
use Filament\Forms\Form;

class EditSales extends EditRecord
{
    protected static string $resource = SalesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('companies_id')
                    ->label('Компанія')
                    ->relationship('company', 'name')
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label('Назва')
                            ->required(),
                    ]),
                Forms\Components\Select::make('user_id')
                    ->label('Користувач')
                    ->relationship('user', 'name')
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label('Ім\'я')
                            ->required(),
                    ]),

                Forms\Components\TextInput::make('total')
                    ->label('Сума')
                    ->reactive()
                    ->required()
                    ->disabled(),
                Forms\Components\TextInput::make('discount')
                    ->label('Знижка')
                    ->reactive()
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('total_discount')
                    ->label('Сума зі знижкою')
                    ->required()
                    ->reactive()
                    ->disabled(),
                Forms\Components\TextInput::make('total_payment')
                    ->label('Оплачено')
                    ->reactive()
                    ->disabled(),
            ]);
    }
}
