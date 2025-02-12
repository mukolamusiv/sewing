<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Models\OrderProcess;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProcessRelationManager extends RelationManager
{
    protected static string $relationship = 'process';

    protected static ?string $title = 'Етапи виробництва';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('step')
                    ->label('Етап виробництва')
                    ->required()
                    ->maxLength(255),
                /*Forms\Components\TextInput::make('status')
                    ->label('Статус')
                    ->required()
                    ->maxLength(255),*/
                Forms\Components\Select::make('user_to')
                    ->label('Відповідальний')
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->preload(),
                /*Forms\Components\Select::make('existing_process')
                    ->label('Вибрати існуючий етап')
                    ->options(OrderProcess::all()->pluck('step', 'id'))
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $process = OrderProcess::find($state);
                            $set('step', $process->step);
                            $set('status', $process->status);
                        }
                    }),*/
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('step')
            ->columns([
                Tables\Columns\TextColumn::make('step')
                    ->label('Етап виробництва'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус'),
                Tables\Columns\SelectColumn::make('user_to')
                    ->label('Відповідальний')
                    ->options(User::all()->pluck('name', 'id')),
                Tables\Columns\TextColumn::make('start_time')
                    ->label('Дата почтку'),
                Tables\Columns\TextColumn::make('end_time')
                    ->label('Дата кінця'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),

            ])
            ->actions([

                Tables\Actions\Action::make('assignUser')
                    ->label('Виконавець')
                    ->form([
                        Forms\Components\Select::make('user_id')
                            ->label('Вибрати відповідального')
                            ->options(User::all()->pluck('name', 'id'))
                            ->searchable()
                            ->preload(),
                    ])
                    ->action(function (array $data, $record) {
                        $record->user_to = $data['user_id'];
                        $record->save();
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
