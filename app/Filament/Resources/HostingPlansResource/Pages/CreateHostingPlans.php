<?php

namespace App\Filament\Resources\HostingPlansResource\Pages;

use App\Filament\Resources\HostingPlansResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHostingPlans extends CreateRecord
{
    protected static string $resource = HostingPlansResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
