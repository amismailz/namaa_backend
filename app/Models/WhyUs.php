<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Symfony\Component\Mailer\Transport;

class WhyUs extends Model
{
    use HasFactory, HasTranslations,  SoftDeletes;
    public $translatable = ['title', 'description'];
    protected $fillable = [
        'title',
        'description',
        'image'
    ];
    protected static function booted(): void
    {
        static::creating(function (WhyUs $item) {
            $slug = Str::slug($item->title);
            $originalSlug = $slug;
            $counter = 1;
            // Check if the slug already exists in the database
            while (WhyUs::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            // Assign the unique slug
            $item->slug = $slug;
        });

        static::updating(function (WhyUs $item) {

            if ($item->isDirty('title')) { // Check if name is being updated
                $slug = Str::slug($item->title);
                $originalSlug = $slug;
                $counter = 1;
                // Check if the slug already exists, but ignore the current record
                while (AboutUs::where('slug', $slug)->where('id', '!=', $item->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                // Assign the unique slug
                $item->slug = $slug;
            }
        });
    }
}
