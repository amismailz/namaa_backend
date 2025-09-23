<?php

namespace App\Filament\Resources\HostingPlansResource\Pages;

use App\Filament\Resources\HostingPlansResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHostingPlans extends ListRecords
{
  protected static string $resource = HostingPlansResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }
}
