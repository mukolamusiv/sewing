<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Models\Wallet;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WalletWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $wallets = Wallet::all();
        $data = [];
        foreach ($wallets as $wallet) {
            $data[] = Stat::make('Гаманець '.$wallet->name, $wallet->amount. ' грн.')->description($wallet->description);
        }
        // return [
        //     Stat::make('Unique views', '192.1k'),
        // ];
        return $data;
    }
}
