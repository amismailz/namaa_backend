<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Str;

class Blog extends Model
{
    use HasFactory, HasTranslations,  SoftDeletes;
    public $translatable = ['title', 'short_description', 'meta_title', 'meta_description', 'description', 'slug'];
    protected $casts = [
        'images' => 'array',
        'published_date' => 'datetime',
    ];
    protected $fillable = [
        'title',
        'short_description',
        'meta_title',
        'meta_description',
        'description',
        'is_published',
        'image',
        'slug',
        'is_popular',
        'published_date'
    ];
    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }
    protected static function booted(): void
    {
        static::creating(function (Blog $item) {
            foreach (['ar', 'en'] as $lang) {
                $slug = $item->getTranslation('slug', $lang);


                $slug = str_replace(' ', '-', $slug);


                $originalSlug = $slug;
                $counter = 1;

                while (Blog::where("slug->$lang", $slug)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }

                $item->setTranslation('slug', $lang, $slug);
            }
        });

        static::updating(function (Blog $item) {
            foreach (['ar', 'en'] as $lang) {
                // فقط إذا تم تعديل الـ slug يدويًا
                // if ($item->isDirty("slug->$lang")) {
                $slug = $item->getTranslation('slug', $lang);
                $slug = str_replace(' ', '-', $slug);

                $originalSlug = $slug;
                $counter = 1;

                while (Blog::where("slug->$lang", $slug)
                    ->where('id', '!=', $item->id)
                    ->exists()
                ) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }

                $item->setTranslation('slug', $lang, $slug);
                // }
            }
        });
    }
}
