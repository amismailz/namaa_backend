<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Str;

class Seo extends Model
{
    use HasFactory, HasTranslations,  SoftDeletes;
    public $translatable = ['title', 'description','twitter_description', 'og_description'];
    protected $fillable = [
        'page_name',
        'title',
        'description',
        'keywords',
        'og_description',
        'og_image',
        'twitter_description',
        'twitter_image',
    ];
    protected static function booted(): void
    {
        static::creating(function (Seo $item) {
            $slug = Str::slug($item->page_name);
            $originalSlug = $slug;
            $counter = 1;
            // Check if the slug already exists in the database
            while (Seo::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            // Assign the unique slug
            $item->slug = $slug;
        });

        static::updating(function (Seo $item) {

            if ($item->isDirty('page_name')) { // Check if name is being updated
                $slug = Str::slug($item->page_name);
                $originalSlug = $slug;
                $counter = 1;
                // Check if the slug already exists, but ignore the current record
                while (Seo::where('slug', $slug)->where('id', '!=', $item->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                // Assign the unique slug
                $item->slug = $slug;
            }
        });
    }
}
