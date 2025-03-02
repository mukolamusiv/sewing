<?php

namespace App\Filament\Resources\SalesResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MaterialsRelationManager extends RelationManager
{
    protected static string $relationship = 'materials';

    protected static ?string $label = 'Матеріали';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('material_id')
                    ->relationship('material', 'name')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) => $set('price', $state ? \App\Models\Material::find($state)->unit_cost : null)),
                Forms\Components\TextInput::make('count')
                    ->reactive()
                    ->numeric()
                    ->default(1)
                    ->afterStateUpdated(fn ($state, callable $set, callable $get) => $set('total', ($state ?? 0) * ($get('price') ?? 0)))
                    ->required(),
                Forms\Components\Select::make('warehouse_id')
                    ->relationship('warehouse', 'name')
                    ->required(),
                Forms\Components\Select::make('order_id')
                    ->relationship('order', 'id')
                    ->nullable(),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->required()
                    //->default(fn ($record) => $record->material->unit_cost ?? null)
                    ,
                    //->afterStateUpdated(fn ($state, callable $set) => $set('total', ($state ?? 0) * ($this->getState('count') ?? 0))),
                Forms\Components\TextInput::make('total')
                    ->numeric()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('material_id')
            ->columns([
                Tables\Columns\TextColumn::make('material.name')
                ->label('Назва'),
                Tables\Columns\TextInputColumn::make('count')
                    ->label('Кількість')
                    //->is_numeric()
                    //->editable()
                    ->afterStateUpdated(function ($state, $record) {
                        $record->total = $state * $record->price;
                        $record->save();
                    }),
                Tables\Columns\TextColumn::make('warehouse.name')
                ->label('Склад'),
                Tables\Columns\TextColumn::make('price')
                ->label('Ціна'),
                Tables\Columns\TextColumn::make('total')
                ->label('Сума'),
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

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['price'] = \App\Models\Material::find($data['material_id'])->unit_cost;
        $data['total'] = $data['price'] * $data['count'];
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        dd($data);
        $data['price'] = \App\Models\Material::find($data['material_id'])->unit_cost;
        $data['total'] = $data['price'] * $data['count'];
        return $data;
    }


    public function create(bool $another = false): void
    {
        dd($this->data);
        parent::create($another);


       // dd($another,$this->record->id,$template->processes);
        // Додатковий код після створення замовлення
    }
}
