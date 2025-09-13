<?php

namespace App\Filament\Resources\HostingPlansResource\Pages;

use App\Filament\Resources\HostingPlansResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHostingPlans extends EditRecord
{
    protected static string $resource = HostingPlansResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
        protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
