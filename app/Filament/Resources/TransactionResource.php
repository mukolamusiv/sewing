<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $modelLabel = 'Транзакція';
    protected static ?string $pluralModelLabel = 'Транзакції';
    protected static ?string $navigationLabel = 'Транзакції';
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $model = Transaction::class;

    //protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('wallet_id')
                    ->label('Гаманець')
                    ->relationship('wallet', 'name')
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->label('Сума')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('type')
                    ->label('Тип')
                    ->options([
                        'надходження' => 'надходження',
                        'списання' => 'списання',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('description')
                    ->label('Опис')
                    ->maxLength(255),
                Forms\Components\Select::make('user_id')
                    ->label('Користувач')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->nullable(),
                Forms\Components\Select::make('companies_id')
                    ->label('Компанія')
                    ->relationship('company', 'name')
                    ->searchable()
                    ->nullable(),
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('wallet.name')
                    ->label('Гаманець')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Сума')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Тип'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Опис')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Користувач')
                    ->sortable(),
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Компанія')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Оновлено')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('wallet_to')
                    ->label('Гаманець до')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('wallet_after')
                    ->label('Гаманець після')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('wallet_id')
                    ->label('Гаманець')
                    ->relationship('wallet', 'name')
                    ->multiple()
                    ->searchable(),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }




}
