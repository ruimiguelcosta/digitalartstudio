<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $this->record->load(['album', 'items.photo', 'items.service']);

        return $data;
    }
}
