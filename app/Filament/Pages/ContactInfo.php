<?php

namespace App\Filament\Pages;

use App\Models\ContactInfo as ModelsContactInfo;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class ContactInfo extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static string $view = 'filament.pages.contact-info-settings';
    protected static ?string $navigationLabel = 'Contact Info';

    public ?ModelsContactInfo $contact;
    public array $data = [];

    public function mount(): void
    {
        $this->contact = ModelsContactInfo::firstOrCreate([]);

        // Prefill form
        $this->data = $this->contact->toArray();

        $this->form->fill($this->data);
    }

    public function getTitle(): string
    {
        return __('Contact Info');
    }

    public static function getNavigationLabel(): string
    {
        return __('Contact Info');
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([


                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->label(__('Email'))->required(),
                        Forms\Components\TextInput::make('map_link')
                            ->label(__('Map Link'))
                            ->required(),
                    ]),

                Forms\Components\Grid::make(2)
                    ->schema([
                        TextInput::make('address.ar')
                            ->label(__('Address (Arabic)'))
                            ->required()
                            ->maxLength(255),

                        TextInput::make('address.en')
                            ->label(__('Address (English)'))
                            ->required()
                            ->maxLength(255),
                    ]),


                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('phone1')
                            ->label(__('Phone 1'))->required(),
                        Forms\Components\TextInput::make('phone2')->required()
                            ->label(__('Phone 2')),
                    ]),
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('landline_1')
                            ->label(__('Landline 1'))->required(),
                        Forms\Components\TextInput::make('landline_2')->required()
                            ->label(__('Landline 2')),
                    ]),
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('whatsapp_number')->required()
                            ->label(__('Whatsapp Number')),
                        Forms\Components\TextInput::make('facebook_link')
                            ->label(__('Facebook Link')),
                        Forms\Components\TextInput::make('instagram_link')
                            ->label(__('Instagram Link')),
                        Forms\Components\TextInput::make('youtube_link')
                            ->label(__('YouTube Link')),
                        Forms\Components\TextInput::make('linkedIn_link')
                            ->label(__('Linkedin Link')),
                        Forms\Components\TextInput::make('tiktok_link')
                            ->label(__('Tiktok Link')),
                        Forms\Components\TextInput::make('twitter_link')
                            ->label(__('Twitter Link')),
                        Forms\Components\TextInput::make('snapchat_link')
                            ->label(__('Snapchat Link')),
                        Forms\Components\TextInput::make('postal_code')->required()
                            ->label(__('Postal Code')),
                        Forms\Components\TextInput::make('tax_id')->required()
                            ->label(__('Tax ID')),
                    ]),


            ]);
    }

    public static function canAccess(): bool
    {
        return Auth::user()?->hasRole('super_admin');
    }

    public function save(): void
    {
        try {
            $validated = Validator::make($this->data, [
                // 'title'       => ['required'],
                // // 'description' => ['required'],
                'email'       => ['required', 'email'],
                'phone1'      => ['required'],
                'phone2'      => ['required'],
                'landline_1'      => ['required'],
                'landline_2'      => ['required'],
                'address.en'     => ['required'],
                'address.ar'     => ['required'],
                'map_link'    => ['required'],
                'facebook_link'  => ['nullable'],
                'instagram_link' => ['nullable'],
                'linkedIn_link'  => ['nullable'],
                'tiktok_link'    => ['nullable'],
                'youtube_link'   => ['nullable'],
                'twitter_link'   => ['nullable'],
                'snapchat_link'   => ['nullable'],
                'whatsapp_number' => ['required'],
                'postal_code' => ['required'],
                'tax_id' => ['required'],

            ])->validate();

            $this->contact->update($validated);
            $this->contact->refresh();

            $this->data = $this->contact->toArray();
            $this->form->fill($this->data);

            Notification::make()
                ->title(__('Saved successfully'))
                ->success()
                ->body(__('Contact Info updated successfully!'))
                ->send();
        } catch (\Throwable $th) {
            Notification::make()
                ->title(__("We can't save the data, please contact the administrator"))
                ->danger()
                ->send();

            throw ValidationException::withMessages([
                'errors' => [$th->getMessage()],
            ]);
        }
    }
    
}
