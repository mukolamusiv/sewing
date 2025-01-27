<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderProcessTemplateResource\Pages;
use App\Filament\Resources\OrderProcessTemplateResource\RelationManagers;
use App\Models\OrderProcessTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderProcessTemplateResource extends Resource
{
    protected static ?string $model = OrderProcessTemplate::class;

   // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Шаблони процесів';
    protected static ?string $navigationGroup = 'Шаблони';

    protected static ?string $modelLabel = 'Шаблон процесів';

    protected static ?string $pluralModelLabel = 'Шаблони процесів';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('step')
                    ->required()
                    ->label('Назва етапу виробництва')
                    ->maxLength(255),
                Forms\Components\TextInput::make('hours_worked')
                    ->label('Час виконання (у хвилинах)')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('rate_per_hour')
                    ->label('Вартість години роботи')
                    ->required(),
                Forms\Components\Checkbox::make('is_moving')
                    ->label('Відбувається списання зі складу під час етапу'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('step')
                    ->label('Етап виробництва')
                    ->searchable(),
                Tables\Columns\TextColumn::make('hours_worked')
                    ->label('Час'),
                Tables\Columns\TextColumn::make('rate_per_hour')
                    ->label('Вартість')
                    ->sortable(),
                Tables\Columns\TextColumn::make('is_moving')
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
            'index' => Pages\ListOrderProcessTemplates::route('/'),
            'create' => Pages\CreateOrderProcessTemplate::route('/create'),
            'edit' => Pages\EditOrderProcessTemplate::route('/{record}/edit'),
        ];
    }
}
