<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialResource\Pages;
use App\Filament\Resources\MaterialResource\RelationManagers;
use App\Models\Material;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MaterialResource extends Resource
{
    protected static ?string $model = Material::class;


    protected static ?string $navigationIcon = 'heroicon-s-scissors';
    protected static ?string $navigationLabel = 'Матеріали';
    protected static ?string $navigationGroup = 'Налаштування';

    protected static ?string $modelLabel = 'Метаріал';

    protected static ?string $pluralModelLabel = 'Матеріали';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Назва матеріалу')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('barcode')
                    ->label('Унікальний код')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label('Опис матерілау')
                    ->columnSpanFull(),
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
                Forms\Components\FileUpload::make('photo')
                    ->label('Фото матерілау'),
                Forms\Components\Select::make('category_id')
                    ->label('Категорія')
                    ->searchable('name')
                    ->required()
                    ->preload()
                    ->relationship('category', 'name')
                ->createOptionForm([
                    Forms\Components\TextInput::make('name')
                        ->label('Назва категорії')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('description')
                        ->label('Опис категорії')
                        ->columnSpanFull(),
//                Forms\Components\TextInput::make('parent_id')
//                    ->numeric(),
                    Forms\Components\Select::make('parent_id')
                        ->label('Належить до категорії')
                        ->relationship('parent', 'name'),
                ]),


              /*  Forms\Components\Select::make('product_type_id')
                    ->label('Тип продукту')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->relationship('productType', 'name')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label('Назва типу продукції')
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
                    ]),*/
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Назва матеріалу')
                    ->searchable(),
                Tables\Columns\TextColumn::make('barcode')
                    ->label('Унікальний код')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit')
                    ->label('Одиниця вимірювання')
                    ->searchable(),
                Tables\Columns\TextColumn::make('photo')
                    ->label('Фото')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Категорія')
                    ->sortable(),
                Tables\Columns\TextColumn::make('productType.name')
                    ->label('Тип продукту')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMaterials::route('/'),
            'create' => Pages\CreateMaterial::route('/create'),
            'edit' => Pages\EditMaterial::route('/{record}/edit'),
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
