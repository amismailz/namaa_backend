<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HostingPlansResource\Pages;
use App\Filament\Resources\HostingPlansResource\RelationManagers;
use App\Models\HostingPlans;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HostingPlansResource extends Resource
{
    protected static ?string $model = HostingPlans::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getNavigationGroup(): ?string
    {
        return __('Hosting Plans');
    }

    public static function getNavigationLabel(): string
    {
        return __('Hosting Plans');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Hosting Plans');
    }

    public static function getModelLabel(): string
    {
        return __('Hosting Plan');
    }


    public static function form(Form $form): Form
    {
        return $form->schema([


            Forms\Components\TextInput::make('name.en')
                ->label(__('Name') . ' (' . __('english') . ')')
                ->required(),
            Forms\Components\TextInput::make('name.ar')
                ->label(__('Name') . ' (' . __('arabic') . ')')
                ->required(),
            // Forms\Components\Select::make('service_id')
            //     ->label('الخدمة المرتبطة')
            //     ->relationship('service', 'title')
            //     ->searchable()
            //     ->required()
            //     ->preload(),
            Forms\Components\TextInput::make('price')->label('السعر')->numeric()->required(),
            Forms\Components\TextInput::make('currency')->label('العملة')->default('EGP')->required(),

            // Forms\Components\Select::make('billing_cycle')
            //     ->label('مدة الاشتراك')
            //     ->options([
            //         'month' => 'شهري',
            //         'year'  => 'سنوي',
            //     ])->required()
            //     ->default('year'),
            Forms\Components\TextInput::make('billing_cycle')->label('مدة الاشتراك')->required(),


            // RichEditor::make('description.en')
            //     ->label(__('Description') . ' (' . __('English') . ')')
            //     ->required(),

            // RichEditor::make('description.ar')
            //     ->label(__('Description') . ' (' . __('Arabic') . ')')
            //     ->required(),


            // Grid::make(2)
            //     ->schema([
            //         RichEditor::make('terms_conditions.en')
            //             ->label(__('Terms & Conditions') . ' (' . __('English') . ')'),

            //         RichEditor::make('terms_conditions.ar')
            //             ->label(__('Terms & Conditions') . ' (' . __('Arabic') . ')'),
            //     ]),


            // Forms\Components\TextInput::make('email_accounts')->label('عدد حسابات البريد')->required()->numeric(),
            // Forms\Components\TextInput::make('storage')->label('المساحة')->required(),
            // Forms\Components\TextInput::make('bandwidth')->label('معدل نقل البيانات')->required(),

            Forms\Components\Toggle::make('free_domain')->label('دومين مجاني'),
            Forms\Components\Toggle::make('is_most_popular')->label('الخطة الأكثر شيوعًا'),


        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('اسم الخطة')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('price')->label('السعر')->sortable(),
                Tables\Columns\TextColumn::make('currency')->label('العملة'),
                Tables\Columns\TextColumn::make('billing_cycle')->label('مدة الاشتراك'),
                // Tables\Columns\IconColumn::make('free_domain')->boolean()->label('دومين مجاني'),
                // Tables\Columns\IconColumn::make('is_most_popular')->boolean()->label('الأكثر شيوعًا'),
                // Tables\Columns\TextColumn::make('service.title')->label('الخدمة'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('تاريخ الإنشاء')->sortable(),
            ])
            ->filters([
                // Tables\Filters\SelectFilter::make('billing_cycle')
                //     ->options([
                //         'month' => 'شهري',
                //         'year'  => 'سنوي',
                //     ]),
                Tables\Filters\TernaryFilter::make('free_domain')->label('دومين مجاني'),
                Tables\Filters\TernaryFilter::make('is_most_popular')->label('الأكثر شيوعًا'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                //  Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListHostingPlans::route('/'),
            'create' => Pages\CreateHostingPlans::route('/create'),
            'edit' => Pages\EditHostingPlans::route('/{record}/edit'),
        ];
    }
}
