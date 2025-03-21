<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MaterialsRelationManager extends RelationManager
{
    protected static string $relationship = 'materials';
    protected static ?string $title = 'Матеріали для виробництва';
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('material_id')
                    ->required()
                    ->label('Матеріал')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->options(\App\Models\Material::all()->pluck('name', 'id')),

                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->label('Кількість')
                    ->numeric()
                    ->live(),


                    Forms\Components\DatePicker::make('write_off')
                    //->required()
                    ->label('Дата списання зі складу')
                    ->live(),


                Forms\Components\Select::make('warehouse_id')
                ->label('Взяти зі складу')
                ->required()
                ->searchable()
                ->preload()
                ->options(\App\Models\Warehouse::pluck('name', 'id'))
                ->rule(function (callable $get):Closure {
                    return function (string $attribute, $value, Closure $fail) use ($get) {
                        $materialId = $get('material_id');
                        $quantity = $get('quantity');
                        $write_off = $get('write_off');

                        if (!$materialId || !$quantity || !$value) {
                            return;
                        }

                        $exists = \App\Models\Inventory::where('material_id', $materialId)
                            ->where('warehouse_id', $value)
                            ->where('quantity', '>=', $quantity)
                            ->exists();

                        if (!$exists and !is_null($write_off)) {
                            $fail('На вибраному складі недостатньо товару!');
                        }
                    };
                })
                ->live(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('material_id')
            ->columns([
                Tables\Columns\TextColumn::make('material.name')->label('Матеріал'),
                Tables\Columns\TextColumn::make('quantity')->label('Кількість'),
                Tables\Columns\TextColumn::make('write_off')->label('Дата списання зі складу'),
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



    private function validateWarehouseStock($warehouseId, callable $get, callable $set)
    {
        $materialId = $get('material_id');
        $quantity = $get('quantity');

        if (!$materialId || !$quantity || !$warehouseId) {
            return;
        }

        $exists = \App\Models\Inventory::where('material_id', $materialId)
            ->where('warehouse_id', $warehouseId)
            ->where('quantity', '>=', $quantity)
            ->exists();

        if (!$exists) {
            $set('warehouse_id', null); // Скидаємо вибір
            Notification::make()
                ->danger()
                ->title('Помилка!')
                ->body('На вибраному складі недостатньо товару!')
                ->send();
        }
    }

    public function beforeSave($record, $request, Closure $next)
    {
        dd($record);
        $this->validateWarehouseStock($record->warehouse_id, $request->get, $request->set);

        return $next($record, $request);
    }


}
