<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderProcessResource\Pages;
use App\Filament\Resources\OrderProcessResource\RelationManagers;
use App\Models\OrderProcess;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderProcessResource extends Resource
{
    protected static ?string $model = OrderProcess::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('order_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('step')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\TextInput::make('user_to')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('start_time'),
                Forms\Components\DateTimePicker::make('end_time'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('step')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('user_to')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrderProcesses::route('/'),
            'create' => Pages\CreateOrderProcess::route('/create'),
            'edit' => Pages\EditOrderProcess::route('/{record}/edit'),
        ];
    }
}
