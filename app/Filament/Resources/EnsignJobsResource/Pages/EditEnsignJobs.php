<?php

namespace App\Filament\Resources\EnsignJobsResource\Pages;

use App\Filament\Resources\EnsignJobsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEnsignJobs extends EditRecord
{
    protected static string $resource = EnsignJobsResource::class;

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
