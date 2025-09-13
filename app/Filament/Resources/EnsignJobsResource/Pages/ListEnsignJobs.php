<?php

namespace App\Filament\Resources\EnsignJobsResource\Pages;

use App\Filament\Resources\EnsignJobsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEnsignJobs extends ListRecords
{
    protected static string $resource = EnsignJobsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
