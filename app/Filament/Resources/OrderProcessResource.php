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

    //protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationIcon = 'heroicon-o-document-plus';
    protected static ?string $navigationLabel = 'Етапи замолень';
    protected static ?string $navigationGroup = 'Замовлення';

    protected static ?string $modelLabel = 'Етап замолення';

    protected static ?string $pluralModelLabel = 'Етапи замолень';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('order_id')
                    ->label('Замовлення')
                    ->required()
                    ->relationship('order', 'status'),
                Forms\Components\TextInput::make('step')
                    ->label('Етап')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->label('Статус')
                    ->required(),
                Forms\Components\TextInput::make('user_to')
                    ->label('Виконавець')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('start_time')
                    ->label('Початок'),
                Forms\Components\DateTimePicker::make('end_time')
                    ->label('Завершення'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_id')
                    ->numeric()
                    ->label('Замовлення')
                    ->sortable(),
                Tables\Columns\TextColumn::make('step')
                    ->label('Етап')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->sortable()
                    ->label('Статус'),
                Tables\Columns\TextColumn::make('user_to')
                    ->label('Виконавець')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->label('Початок')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_time')
                    ->label('Завершення')
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
