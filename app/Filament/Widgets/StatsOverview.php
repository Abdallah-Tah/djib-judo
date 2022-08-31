<?php

namespace App\Filament\Widgets;

use App\Models\Club;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Clubs', Club::where('user_id', auth()->id())->count())
                ->icon('ri-team-fill')
                ->color('primary'),
            Card::make('Users', auth()->user()->count())
                ->icon('ri-user-fill')
                ->color('secondary'),
            Card::make('Players', auth()->user()->players()->count())
                ->icon('ri-user-fill')
                ->color('success'),

            Card::make('Invoice', auth()->user()->invoices()->count())
                ->icon('tni-invoice')
                ->color('info'),
        ];
    }
}
