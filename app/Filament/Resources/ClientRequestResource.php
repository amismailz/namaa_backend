<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientRequestResource\Pages;
use App\Filament\Resources\ClientRequestResource\RelationManagers;
use App\Models\ClientRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientRequestResource extends Resource
{
    protected static ?string $model = ClientRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return __('Requests');
    }
    public static function getNavigationLabel(): string
    {
        return __('Client Requests');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Client Requests');
    }

    public static function getModelLabel(): string
    {
        return __('Client Request');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->label(__('ID')),
                TextColumn::make('name')->label(__('name'))->sortable()->searchable(),
                TextColumn::make('phone')->label(__('Phone'))->sortable()->searchable(),
                TextColumn::make('email')->label(__('Email'))->sortable()->searchable(),
                TextColumn::make('description')->label(__('Description'))->limit(50),
                TextColumn::make('goal')
                    ->label(__('Goal'))
                    ->formatStateUsing(function ($state) {
                        if (is_array($state)) {
                            return collect($state)
                                ->map(fn($item) => \App\Enums\GoalEnum::tryFrom($item)?->label() ?? $item)
                                ->join(', ');
                        }
                        return $state ? \App\Enums\GoalEnum::tryFrom($state)?->label() ?? $state : '-';
                    })
                    ->wrap(),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime('d M, Y H:i:s')
                    ->sortable()
                    ->tooltip(fn($record) => $record->created_at?->format('Y-m-d H:i:s') ?? __('No Date')),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('goal')
                    ->label(__('Goal'))
                    ->options(\App\Enums\GoalEnum::options())
                    ->query(function (Builder $query, array $data) {
                        if ($data['value']) {
                            $query->whereJsonContains('goal', $data['value']);
                        }
                    })
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
             //   Tables\Actions\ViewAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientRequests::route('/'),
            'create' => Pages\CreateClientRequest::route('/create'),
            'edit' => Pages\EditClientRequest::route('/{record}/edit'),
        ];
    }
}
