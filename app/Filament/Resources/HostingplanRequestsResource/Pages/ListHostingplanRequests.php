<?php

namespace App\Filament\Resources\HostingplanRequestsResource\Pages;

use App\Filament\Resources\HostingplanRequestsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHostingplanRequests extends ListRecords
{
    protected static string $resource = HostingplanRequestsResource::class;

    protected function getHeaderActions(): array
    {
        return [
         //   Actions\CreateAction::make(),
        ];
    }
}
