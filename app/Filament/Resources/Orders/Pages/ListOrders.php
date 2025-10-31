<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->with(['album', 'items.photo', 'items.service']);
    }
}
