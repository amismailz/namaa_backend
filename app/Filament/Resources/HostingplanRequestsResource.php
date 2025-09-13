<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HostingplanRequestsResource\Pages;
use App\Filament\Resources\HostingplanRequestsResource\RelationManagers;
use App\Models\HostingplanRequests;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HostingplanRequestsResource extends Resource
{
    protected static ?string $model = HostingplanRequests::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return __('Requests');
    }
    public static function getNavigationLabel(): string
    {
        return __('Hosting Plan Requests');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Hosting Plan Requests');
    }

    public static function getModelLabel(): string
    {
        return __('Hosting Plan Request');
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
                TextColumn::make('message')->label(__('Message'))->limit(50),
                TextColumn::make('hosting_plan.name')
                    ->label(__('Hosting Plan'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime('d M, Y H:i:s')
                    ->sortable()
                    ->tooltip(fn($record) => $record->created_at?->format('Y-m-d H:i:s') ?? __('No Date')),
            ])->defaultSort('created_at', 'desc')
            ->filters([Tables\Filters\SelectFilter::make('hosting_plan_id')
                ->label(__('Hosting Plan'))
                ->relationship('hosting_plan', 'name'),])
            ->actions([
                // Tables\Actions\EditAction::make(),
              //  Tables\Actions\ViewAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //       Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListHostingplanRequests::route('/'),
            //  'create' => Pages\CreateHostingplanRequests::route('/create'),
            //  'edit' => Pages\EditHostingplanRequests::route('/{record}/edit'),
        ];
    }
}
