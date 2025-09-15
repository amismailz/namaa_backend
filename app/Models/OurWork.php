<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class OurWork extends Model
{
    use HasFactory, HasTranslations,  SoftDeletes;
    public $translatable = ['title', 'description', 'slug'];
    protected $fillable = [
        'title',
        'description',
        'image',
        'link',
        'service_id',
        'slug'
    ];
    protected static function booted(): void
    {
        static::creating(function (OurWork $item) {

            foreach (['ar', 'en'] as $lang) {
                // إذا المستخدم لم يدخل slug
                $slug = $item->getTranslation('slug', $lang);
                if (!$slug) {
                    $title = $item->getTranslation('title', $lang) ?? '';
                    if ($title) {
                        $slug = Str::slug($title);

                        $originalSlug = $slug;
                        $counter = 1;

                        while (OurWork::where("slug->$lang", $slug)->exists()) {
                            $slug = $originalSlug . '-' . $counter;
                            $counter++;
                        }

                        $item->setTranslation('slug', $lang, $slug);
                    }
                }
            }
        });

        static::updating(function (OurWork $item) {

            foreach (['ar', 'en'] as $lang) {
                // إذا المستخدم لم يدخل slug
                $slug = $item->getTranslation('slug', $lang);
                if (!$slug) {
                    $title = $item->getTranslation('title', $lang) ?? '';
                    if ($title) {
                        $slug = Str::slug($title);

                        $originalSlug = $slug;
                        $counter = 1;

                        while (OurWork::where("slug->$lang", $slug)->where('id', '!=', $item->id)->exists()) {
                            $slug = $originalSlug . '-' . $counter;
                            $counter++;
                        }

                        $item->setTranslation('slug', $lang, $slug);
                    }
                }
            }
        });
    }
    public function service()
    {
        return $this->belongsTo(OurService::class);
    }
}
