<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderTemplateResource\Pages;
use App\Filament\Resources\OrderTemplateResource\RelationManagers;
use App\Filament\Resources\OrderTemplateResource\RelationManagers\MaterialRelationManager;
use App\Models\OrderTemplate;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderTemplateResource extends Resource
{
    protected static ?string $model = OrderTemplate::class;

   // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Шаблони виробництва';
    protected static ?string $navigationGroup = 'Шаблони';

    protected static ?string $modelLabel = 'Шаблон виробництва';

    protected static ?string $pluralModelLabel = 'Шаблони виробництва';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Шаблон')
                        ->id('tempale')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                            ->label('Назва шаблону')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('material_id')
                            ->label('Продукт який маємо отримати')
                            ->required()
                            ->searchable()
                            ->relationship('material', 'name'),
                            Forms\Components\TextInput::make('price')
                            ->label('Вартість')
                            ->required()
                            ->maxLength(255),

                        ]),
                    Wizard\Step::make('Матеріали')
                        ->id('materials')
                        ->schema([
                            Repeater::make('materials')
                            //->relationship('parish')
                            ->schema([
                                Forms\Components\Select::make('material_id')
                                    ->label('Назва матеріалу')
                                    ->searchable()
                                    ->relationship('material', 'name')
                                    ->required(),
                                Forms\Components\TextInput::make('quantity')
                                    ->label('Кількість')
                                    ->numeric()
                                    ->required(),
                            ])
                            ->minItems(1)
                            ->maxItems(10)
                            ->label('Додати датеріали для пошиття')
                            ->required(),
                        ]),
                        Wizard\Step::make('Етапи виробництва')
                        ->id('stages')
                        ->schema([
                            Repeater::make('process')
                            //->relationship('parish')
                            ->schema([
                                Forms\Components\Select::make('step')
                                    ->label('Назва етапу')
                                    ->searchable()
                                    ->relationship('processes', 'step')
                                    ->required(),
                            ])
                            ->minItems(1)
                            ->maxItems(10)
                            ->label('Додати етап')
                            ->required(),
                        ]),

                ]),



                    /*
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->default(100)
                    ->label('Орієнтовна вартість вартість')*/
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Назва шаблону')
                    ->searchable(),
                Tables\Columns\TextColumn::make('material.name')
                    ->label('Продукт')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Вартість')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
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
            RelationManagers\ProcessRelationManager::class,
            RelationManagers\MaterialRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrderTemplates::route('/'),
            'create' => Pages\CreateOrderTemplate::route('/create'),
            'edit' => Pages\EditOrderTemplate::route('/{record}/edit'),
        ];
    }
}
