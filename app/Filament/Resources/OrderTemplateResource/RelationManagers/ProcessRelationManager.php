<?php

namespace App\Filament\Resources\OrderTemplateResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProcessRelationManager extends RelationManager
{
    protected static string $relationship = 'processes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('step')
                    ->required()
                    ->label('Назва етапу виробництва')
                    ->maxLength(255),
                Forms\Components\TextInput::make('hours_worked')
                    ->label('Час виконання (у хвилинах)')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('rate_per')
                    ->label('Вартість години роботи')
                    ->required(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('step')
            ->columns([
                Tables\Columns\TextColumn::make('step')
                ->label('Назва етапу'),
                Tables\Columns\TextColumn::make('hours_worked')
                ->label('Орієнтовний час виконання'),
                Tables\Columns\TextColumn::make('rate_per')
                ->label('Зарплата'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
