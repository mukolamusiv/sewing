<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductTypeResource\Pages;
use App\Filament\Resources\ProductTypeResource\RelationManagers;
use App\Models\ProductType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductTypeResource extends Resource
{
    protected static ?string $model = ProductType::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Типи матеріалів';
    protected static ?string $navigationGroup = 'Налаштування';

    protected static ?string $modelLabel = 'Тип матеріалу';

    protected static ?string $pluralModelLabel = 'Типи матеріалів';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Назва типу продукту')
                    ->required(),
                Forms\Components\TextInput::make('description')
                    ->label('Опис типу продукції')
                    ->required(),
                Forms\Components\Select::make('unit')
                    ->label('Одиниця вимірювання')
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Назва типу матеріалів')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Опис'),
                Tables\Columns\TextColumn::make('unit')
                    ->label('Одиниці вимірювання')
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
            'index' => Pages\ListProductTypes::route('/'),
            'create' => Pages\CreateProductType::route('/create'),
            'edit' => Pages\EditProductType::route('/{record}/edit'),
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
