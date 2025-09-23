<?php

namespace App\Filament\Resources;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Filament\Resources\AboutUsResource\Pages;
use App\Models\AboutUs;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AboutUsResource extends Resource
{
    protected static ?string $model = AboutUs::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getNavigationLabel(): string
    {
        return __('About Us');
    }

    public static function getPluralModelLabel(): string
    {
        return __('About Us');
    }

    /**
     * Get the model label
     *
     * @return string
     */
    /*************  ✨ Windsurf Command ⭐  *************/
    /*******  d3bd3c2f-038f-4709-8489-077a7a02c467  *******/
    public static function getModelLabel(): string
    {
        return __('About Us');
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

                Section::make(__('Media'))
                    ->schema([
                        Fieldset::make(__('Media'))
                            ->schema([

                                FileUpload::make('image')
                                    ->label(__('Images'))
                                    ->image()
                                    ->directory('about')
                                    ->required()
                                    ->multiple()
                                    ->imagePreviewHeight('100'),
                            ])
                            ->columns(1),
                    ])
                    ->collapsed(false),


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
                // TextColumn::make('description')->label(__('Description'))->limit(50),
              //  ImageColumn::make('image')->label('Image')->circular()->width(50)->height(50),
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
               'index' => Pages\ListAboutUss::route('/'),
            'create' => Pages\CreateAboutUs::route('/create'),
            'edit' => Pages\EditAboutUs::route('/{record}/edit'),
        ];
    }
}
