<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class ContactInfo extends Model
{
    use HasFactory, HasTranslations,  SoftDeletes;
    public $translatable = ['title', 'description', 'address'];

    protected $fillable = [
        'title',
        'description',
        'address',
        'phone1',
        'phone2',
        'landline_1',
        'landline_2',
        'email',
        'facebook_link',
        'instagram_link',
        'twitter_link',
        'linkedin_link',
        'youtube_link',
        'tiktok_link',
        'postal_code',
        'tax_id',
        'map_link',
        'whatsapp_number',
    ];
}
