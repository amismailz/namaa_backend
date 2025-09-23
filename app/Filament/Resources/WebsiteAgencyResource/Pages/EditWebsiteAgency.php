<?php

namespace App\Filament\Resources\WebsiteAgencyResource\Pages;

use App\Filament\Resources\WebsiteAgencyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWebsiteAgency extends EditRecord
{
    protected static string $resource = WebsiteAgencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //   Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
