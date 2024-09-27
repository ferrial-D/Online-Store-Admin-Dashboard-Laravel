<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Order;

class OrderStats extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Stat::make('New Orders', Order::query()->where('status', 'new')->count())
                ->description('Number of new orders'),

            Stat::make('Processing Orders', Order::query()->where('status', 'processing')->count())
                ->description('Number of processing orders'),

            Stat::make('Shipped Orders', Order::query()->where('status', 'shipped')->count())
                ->description('Number of shipped orders'),
        ];
    }
}
