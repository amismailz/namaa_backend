<?php

namespace App\Filament\Resources\WebsiteAgencyResource\Pages;

use App\Filament\Resources\WebsiteAgencyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWebsiteAgency extends CreateRecord
{
    protected static string $resource = WebsiteAgencyResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
    
}
