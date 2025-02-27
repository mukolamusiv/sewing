<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialOrderTemplateResource\Pages;
use App\Filament\Resources\MaterialOrderTemplateResource\RelationManagers;
use App\Models\Material_orders_tempale;
use App\Models\MaterialOrderTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MaterialOrderTemplateResource extends Resource
{
    protected static ?string $model = Material_orders_tempale::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    //protected static ?string $navigationIcon = 'heroicon-s-scissors';
    protected static ?string $navigationLabel = 'Шаблони метеріалів';
    protected static ?string $navigationGroup = 'Шаблони';

    protected static ?string $modelLabel = 'Шаблони метеріалів';

    protected static ?string $pluralModelLabel = 'Шаблони метеріалів';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('material_id')
                    ->required(),
                Forms\Components\TextInput::make('order_template_id')
                    ->required(),
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('material_id'),
                Tables\Columns\TextColumn::make('order_template_id'),
                Tables\Columns\TextColumn::make('quantity'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
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
            'index' => Pages\ListMaterialOrderTemplates::route('/'),
            'create' => Pages\CreateMaterialOrderTemplate::route('/create'),
            'edit' => Pages\EditMaterialOrderTemplate::route('/{record}/edit'),
        ];
    }
}
