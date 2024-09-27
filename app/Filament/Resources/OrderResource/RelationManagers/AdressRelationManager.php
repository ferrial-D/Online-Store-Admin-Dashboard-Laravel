<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdressRelationManager extends RelationManager
{
    protected static string $relationship = 'adress';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')
                ->required()
                ->maxLength('255'),

                TextInput::make('last_name')
                ->required()
                ->maxLength('255'),

                TextInput::make('phone')
                ->required()
                ->tel()
                ->maxLength('20'),

                TextInput::make('ciity')
                ->required()
                ->maxLength('255'),

                TextInput::make('state')
                ->required()
                ->maxLength('255'),

                TextInput::make('zip_code')
                ->required()
                ->numeric()
                ->maxLength('10'),

                Textarea::make('street_adress')
                ->required()
                ->columnSpanFull(),


            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('street_adress')
            ->columns([
                TextColumn::make('fullname')
                ->label('Full Name'),

                TextColumn::make('phone'),
                TextColumn::make('city'),
                TextColumn::make('zip_code'),
                TextColumn::make('street_adress'),
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
}
