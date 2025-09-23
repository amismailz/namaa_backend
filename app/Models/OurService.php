<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class OurService extends Model
{
    use HasFactory, HasTranslations,  SoftDeletes;
    public $translatable = ['title', 'description'];
    protected $fillable = [
        'slug',
        'title',
        'description',
        'image'
    ];
    public function subServices(): HasMany
    {
        return $this->hasMany(SubService::class);
    }
    protected static function booted(): void
    {
        static::creating(function (OurService $item) {
            foreach (['ar', 'en'] as $lang) {
                $slug = $item->getTranslation('slug', $lang);


                $slug = str_replace(' ', '-', $slug);


                $originalSlug = $slug;
                $counter = 1;

                while (OurService::where("slug->$lang", $slug)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }

                $item->setTranslation('slug', $lang, $slug);
            }
        });

        static::updating(function (OurService $item) {
            foreach (['ar', 'en'] as $lang) {
                // فقط إذا تم تعديل الـ slug يدويًا
                // if ($item->isDirty("slug->$lang")) {
                $slug = $item->getTranslation('slug', $lang);
                $slug = str_replace(' ', '-', $slug);

                $originalSlug = $slug;
                $counter = 1;

                while (OurService::where("slug->$lang", $slug)
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
