<?php

namespace App\Filament\Widgets;
use App\Models\Order; // Add this line
use Filament\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use App\Filament\Resources\OrderResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;


class LatestOrders extends BaseWidget
{
    protected int | string| array $columnSpan ='full';

    protected static ?int $sort =2;
    protected static ?string $recordTitleAttribute = 'name';
    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([ 
                TextColumn::make('id')
                ->label('order ID')
                ->searchable(),

                TextColumn::make('user.name')
                ->searchable(),

                TextColumn::make('grand_total')
                ->money('INR'),

                TextColumn::make('status')
                ->badge(),

                TextColumn::make('payement_status')
                ->sortable()
                ->badge()
                ->searchable(),

                TextColumn::make('created_at')
                ->label('Order Date')
                ->dateTime(),
            ])
            ->actions([
                ViewAction::make('View Order')
                ->url(fn (Order $record):string => OrderResource::getUrl('view', ['record'=> $record]))


            ]);
    }
}
