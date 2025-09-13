<?php

namespace App\Filament\Resources\EnsignJobsResource\Pages;

use App\Filament\Resources\EnsignJobsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEnsignJobs extends CreateRecord
{
    protected static string $resource = EnsignJobsResource::class;
            protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
