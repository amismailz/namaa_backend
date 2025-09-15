<?php

namespace App\Filament\Resources;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Filament\Resources\BlogResource\Pages;
use App\Filament\Resources\BlogResource\RelationManagers;
use App\Models\Blog;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getNavigationLabel(): string
    {
        return __('Blogs');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Blogs');
    }

    public static function getModelLabel(): string
    {
        return __('Blog');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title.ar')
                    ->label(__('Title (Arabic)'))
                    ->required()
                    ->maxLength(255),

                TextInput::make('title.en')
                    ->label(__('Title (English)'))
                    ->required()
                    ->maxLength(255),


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




                Grid::make(2)
                    ->schema([

                        DateTimePicker::make('published_date')
                            ->label(__('Published Date'))
                            ->native(false)
                            ->required(),
                    ])
                    ->columns(2),
                // TextInput::make('short_description.ar')
                //     ->label(__('Short description (Arabic)'))
                //     ->required()
                //     ->maxLength(255),

                // TextInput::make('short_description.en')
                //     ->label(__('Short description (English)'))
                //     ->required()
                //     ->maxLength(255),

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

                Textarea::make('meta_title.ar')
                    ->label(__('Meta title (Arabic)'))
                    ->maxLength(255),

                Textarea::make('meta_title.en')
                    ->label(__('Meta title (English)'))
                    ->maxLength(255),
                Textarea::make('meta_description.ar')
                    ->label(__('Meta description (Arabic)')),

                Textarea::make('meta_description.en')
                    ->label(__('Meta description (English)')),
                Section::make(__('Media'))
                    ->schema([
                        Fieldset::make(__('Media'))
                            ->schema([

                                FileUpload::make('image')
                                    ->label(__('Image'))
                                    ->image()
                                    ->directory('blogs')
                                    ->required()
                                    ->imagePreviewHeight('100'),
                            ])
                            ->columns(1),
                    ])
                    ->collapsed(false),
                Repeater::make('faqs')
                    ->relationship('faqs')
                    ->label(__('FAQs'))
                    ->schema([
                        Forms\Components\TextInput::make('question.en')
                            ->label(__('Question') . ' (' . __('english') . ')')
                            ->required(),
                        Forms\Components\TextInput::make('question.ar')
                            ->label(__('Question') . ' (' . __('arabic') . ')')
                            ->required(),

                        Forms\Components\TextInput::make('answer.en')
                            ->label(__('Answer') . ' (' . __('english') . ')')
                            ->required(),
                        Forms\Components\TextInput::make('answer.ar')
                            ->label(__('Answer') . ' (' . __('arabic') . ')')
                            ->required(),
                    ])
                    ->collapsible()
                    ->createItemButtonLabel(__('+ Add FAQ'))
                    ->columns(2), // two columns in one row
                Grid::make(2)
                    ->schema([

                        Toggle::make('is_published')->label(__('Is published?'))->default(true),
                        Toggle::make('is_popular')->label(__('Is popular?'))->default(false),
                    ])




            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->label(__('ID')),

                TextColumn::make('title')->label(__('Title'))->searchable()->sortable(),

                TextColumn::make('slug')->label(__('Slug'))->searchable()->sortable(),
                //  TextColumn::make('short_description')->label(__('Short description'))->limit(50),
                ImageColumn::make('image')->label(__('Image'))->circular()->width(50)->height(50),

                ToggleColumn::make('is_published')
                    ->label(__('Is published?'))
                    ->onColor('success')
                    ->offColor('gray')
                    ->onIcon('heroicon-m-check')
                    ->offIcon('heroicon-m-x-mark')
                    ->getStateUsing(fn($record) => $record->is_published)
                    ->afterStateUpdated(fn($record, $state) => $record->update(['is_published' => $state])),

                ToggleColumn::make('is_popular')
                    ->label(__('Is popular?'))
                    ->onColor('success')
                    ->offColor('gray')
                    ->onIcon('heroicon-m-check')
                    ->offIcon('heroicon-m-x-mark')
                    ->getStateUsing(fn($record) => $record->is_popular)
                    ->afterStateUpdated(fn($record, $state) => $record->update(['is_popular' => $state])),
                TextColumn::make('published_date')
                    ->label(__('Published Date'))
                    ->dateTime('d M, Y H:i:s')
                    ->sortable()
                    ->tooltip(fn($record) => $record->created_at?->format('Y-m-d H:i:s') ?? __('No Date')),
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
