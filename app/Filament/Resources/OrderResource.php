<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\Widgets\CurrentProcessStageWidget;
use App\Filament\Resources\OrderResource\Widgets\MaterialsCountWidget;
use App\Filament\Resources\OrderResource\Widgets\TotalCostWidget;
use App\Filament\Resources\OrderResource\Widgets\TotlaCost;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;


    protected static ?string $navigationIcon = 'heroicon-o-document-plus';
    protected static ?string $navigationLabel = 'Замовлення';
    protected static ?string $navigationGroup = 'Замовлення';

    protected static ?string $modelLabel = 'Замовлення';

    protected static ?string $pluralModelLabel = 'Замовлення';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_id')
                    ->label('Замовник')
                    ->required()
                    ->relationship('company', 'name'),
                Forms\Components\Select::make('status')
                    ->label('Статус замовлення')
                    ->required()
                    ->options([
                        'нове' => 'Нове',
                        'очікує матеріали' => 'очікує матеріали',
                        'виготовляється' => 'виготовляється',
                        'готово' => 'готово',
                        'доставлено' => 'доставлено',
                    ]),
                Forms\Components\TextInput::make('total_cost')
                    ->label('Орієнтовна вартість')
                    ->hidden()
                    ->numeric(),
                Forms\Components\Select::make('order_template_id')
                    //->required()
                    ->label('Шаблон замовлення')
                    ->relationship('template', 'name'),
                Forms\Components\Select::make('material_id')
                    //->required()
                    ->label('Виготовити продукт')
                    ->relationship('material', 'name'),
//                Forms\Components\Repeater::make('material')
//                ->schema([
//                    Forms\Components\Select::make('material_id')
//                    ->label('Матеріал'),
//                    Forms\Components\TextInput::make('')
//                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Замовник')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('material.name')
                    ->label('Продукт')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус замовлення'),
                Tables\Columns\TextColumn::make('total_cost')
                    ->label('Вартість')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order_template_id')
                    ->numeric()
                    ->hidden()
                    ->sortable(),
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
            RelationManagers\ProcessRelationManager::class,
            RelationManagers\MaterialsRelationManager::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getWidgets(): array
    {
        return [
            TotlaCost::class,
            CurrentProcessStageWidget::class,
            MaterialsCountWidget::class,
            TotalCostWidget::class,
        ];
    }
}
