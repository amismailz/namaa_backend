<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Str;

class SubService extends Model
{
    use HasFactory, HasTranslations,  SoftDeletes;
    public $translatable = ['title', 'description'];
    protected $fillable = [
        'service_id',
        'title',
        'slug',
        'description',
        'image',
    ];
    public function service()
    {
        return $this->belongsTo(OurService::class);
    }
    protected static function booted(): void
    {
        static::creating(function (SubService $item) {
            foreach (['ar', 'en'] as $lang) {
                $slug = $item->getTranslation('slug', $lang);


                $slug = str_replace(' ', '-', $slug);


                $originalSlug = $slug;
                $counter = 1;

                while (SubService::where("slug->$lang", $slug)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }

                $item->setTranslation('slug', $lang, $slug);
            }
        });

        static::updating(function (SubService $item) {
            foreach (['ar', 'en'] as $lang) {
                // فقط إذا تم تعديل الـ slug يدويًا
                // if ($item->isDirty("slug->$lang")) {
                $slug = $item->getTranslation('slug', $lang);
                $slug = str_replace(' ', '-', $slug);

                $originalSlug = $slug;
                $counter = 1;

                while (SubService::where("slug->$lang", $slug)
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
