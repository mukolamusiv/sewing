<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockMovementResource\Pages;
use App\Filament\Resources\StockMovementResource\RelationManagers;
use App\Models\StockMovement;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StockMovementResource extends Resource
{
    protected static ?string $model = StockMovement::class;

   // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    protected static ?string $navigationIcon = 'heroicon-m-arrows-pointing-out';
    protected static ?string $navigationLabel = 'Переміщення по складу';
    protected static ?string $navigationGroup = 'Продукція';

    protected static ?string $modelLabel = 'Переміщення по складу';

    protected static ?string $pluralModelLabel = 'Переміщення по складу';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основне')->schema([
                    Forms\Components\Select::make('movement_type')
                    ->label('Тип переміщення')
                    ->required()
                    ->options([
                        'in' => 'Надходження',
                        'out' => 'Списання',
                        'move'=> 'Переміщення',
                    ])->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state === 'in') {
                            $set('warehouse_in_id', null);
                            $set('warehouse_out_id', null);
                        } elseif ($state === 'move') {
                            $set('warehouse_in_id', null);
                            $set('warehouse_out_id', null);
                        }
                    }),

                Forms\Components\Select::make('warehouse_in_id')
                    ->label('На склад')
                    ->visible(fn ($get) => $get('movement_type') === 'in' || $get('movement_type') === 'move')
                    ->required(fn ($get) => $get('movement_type') === 'in' || $get('movement_type') === 'move')
                    ->relationship('warehouse_in', 'name'),

                    Forms\Components\Select::make('warehouse_out_id')
                    ->label('Зі складу')
                    ->visible(fn ($get) => $get('movement_type') === 'out' || $get('movement_type') === 'move')
                    ->required(fn ($get) => $get('movement_type') === 'out' || $get('movement_type') === 'move')

                    ->relationship('warehouse_out', 'name'),
                Forms\Components\Select::make('material_id')
                    ->label('Матеріал')
                    ->required()
                    ->relationship('material', 'name'),
                Forms\Components\TextInput::make('quantity')
                    ->label('Кількість')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('unit')
                    ->label('Одиниця вимірювання') // дописати автоматичне підтягнення за матеріалом
                    ->required()
                    ->options([
                        'm' => 'Метри',
                        'sm' => 'Сантиметри',
                        'mm' => 'Міліметри',
                        'm-p' => 'Метри погонні',
                        'sm-p' => 'Сантиметри погонні',
                        'mm-p' => 'Міліметри погонні',
                        'm2' => 'Метри квадратні',
                        'od' => 'Одиниці',
                    ]),
                Forms\Components\TextInput::make('balance_before')
                    ->label('Кількість перед переміщенням')
                    ->required() //треба дописати механізм автоматичного вирахування
                    ->numeric(),
                Forms\Components\TextInput::make('balance_after')
                    ->label('Актуальна кількість')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('supplier_id')
                    ->label('Постачальник/Клієнт')
                    ->searchable()
                    ->preload()
                    ->relationship('supplier', 'name'),

                Forms\Components\Select::make('user_id')
                    ->label('Користувач що здійснив переміщення')
                    ->required() // дописати автоматичне заповнення активним користувачем
                    ->searchable()
                    ->preload()
                    ->relationship('user', 'name'),
                ])


            ]);

/*
            ->afterSave(function ($record) {
                // Дії після збереження форми
                // Наприклад, оновлення балансу після переміщення
              //  $record->balance_after = $record->balance_before - $record->quantity; // Приклад, змініть на ваш механізм
            });*/
    }



    protected function mutateFormDataBeforeCreate(array $data): array
    {
        dd($data);
        // Дії перед створенням запису
        //$data['balance_before'] = $data['quantity']; // Приклад, змініть на ваш механізм
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        dd($data);
        // Дії перед збереженням запису
       // $data['balance_after'] = $data['balance_before'] - $data['quantity']; // Приклад, змініть на ваш механізм
        return $data;
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('warehouse.name')
                    ->label('Склад')
                    ->sortable(),
                Tables\Columns\TextColumn::make('material.name')
                    ->label('Матеріал')
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Кількість')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit')
                    ->label('Одиниця виміру')
                    ->searchable(),
                Tables\Columns\TextColumn::make('balance_before')
                    ->label('Попередній залишок')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('balance_after')
                    ->label('Залишок після переміщення')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('supplier.name')
                    ->label('Постачальник/Клієнт')
                    ->sortable(),
                Tables\Columns\TextColumn::make('movement_type')
                    ->label('Тип переміщення'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Користувач')
                    ->toggleable(isToggledHiddenByDefault: true)
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
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListStockMovements::route('/'),
            'create' => Pages\CreateStockMovement::route('/create'),
            'edit' => Pages\EditStockMovement::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
