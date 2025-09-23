<?php

namespace App\Filament\Resources;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Filament\Resources\SubServiceResource\Pages;
use App\Filament\Resources\SubServiceResource\RelationManagers;
use App\Models\SubService;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubServiceResource extends Resource
{
    protected static ?string $model = SubService::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return __('Services');
    }

    public static function getNavigationLabel(): string
    {
        return __('Sub Services');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Sub Services');
    }

    public static function getModelLabel(): string
    {
        return __('Sub Service');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title.en')
                    ->label(__('Title') . ' (' . __('english') . ')')
                    ->required(),
                Forms\Components\TextInput::make('title.ar')
                    ->label(__('Title') . ' (' . __('arabic') . ')')
                    ->required(),

                TextInput::make('slug.en')
                    ->required()
                    ->label(__('Slug (English)'))->unique(
                        table: 'blogs',
                        column: 'slug->en',
                        ignoreRecord: true
                    ),
                TextInput::make('slug.ar')
                    ->required()
                    ->label(__('Slug (Arabic)'))->unique(
                        table: 'blogs',
                        column: 'slug->en',
                        ignoreRecord: true
                    ),
                TinyEditor::make('description.ar')
                    ->label(__('Description (Arabic)'))
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsVisibility('public')
                    ->fileAttachmentsDirectory('uploads')
                    ->profile('default|simple|full|minimal|none|custom')
                    ->direction('auto|rtl|ltr')
                    ->columnSpan('full')
                    ->required(),
                TinyEditor::make('description.en')
                    ->label(__('Description (English)'))
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsVisibility('public')
                    ->fileAttachmentsDirectory('uploads')
                    ->profile('default|simple|full|minimal|none|custom')
                    ->direction('auto|rtl|ltr')
                    ->columnSpan('full')
                    ->required(),
                Select::make('sevice_id')
                    ->label(__('Service'))
                    ->relationship('service', 'title')
                    ->required(),
                FileUpload::make('image')
                    ->label(__('Image'))
                    ->image()
                    ->directory('our-services')
                    ->disk('public')
                    ->visibility('public')
                    ->required()
                    ->imagePreviewHeight('100'),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->label(__('ID')),
                TextColumn::make('title')->label(__('Title'))->sortable()->searchable(),
                TextColumn::make('slug')->label(__('Slug'))->sortable()->searchable(),
                // TextColumn::make('description')->label(__('Description'))->limit(50),
                TextColumn::make('service.title')->label(__('Service'))->sortable()->searchable(),
                ImageColumn::make('image')->label(__('Image'))->circular()->width(50)->height(50),

                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime('d M, Y H:i:s')
                    ->sortable()
                    ->tooltip(fn($record) => $record->created_at?->format('Y-m-d H:i:s') ?? __('No Date')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListSubServices::route('/'),
            'create' => Pages\CreateSubService::route('/create'),
            'edit' => Pages\EditSubService::route('/{record}/edit'),
        ];
    }
}
