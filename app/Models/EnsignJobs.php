<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Str;

class EnsignJobs extends Model
{

    use HasFactory, HasTranslations,  SoftDeletes;
    public $translatable = ['title', 'description','slug'];
    protected $fillable = [
        'title',
        'description',
        'image',
        'slug'
    ];
    protected static function booted(): void
    {
        static::creating(function (EnsignJobs $item) {

            foreach (['ar', 'en'] as $lang) {
                // إذا المستخدم لم يدخل slug
                $slug = $item->getTranslation('slug', $lang);
                if (!$slug) {
                    $title = $item->getTranslation('title', $lang) ?? '';
                    if ($title) {
                        $slug = Str::slug($title);

                        $originalSlug = $slug;
                        $counter = 1;

                        while (EnsignJobs::where("slug->$lang", $slug)->exists()) {
                            $slug = $originalSlug . '-' . $counter;
                            $counter++;
                        }

                        $item->setTranslation('slug', $lang, $slug);
                    }
                }
            }
        });

        static::updating(function (EnsignJobs $item) {

            foreach (['ar', 'en'] as $lang) {
                // إذا المستخدم لم يدخل slug
                $slug = $item->getTranslation('slug', $lang);
                if (!$slug) {
                    $title = $item->getTranslation('title', $lang) ?? '';
                    if ($title) {
                        $slug = Str::slug($title);

                        $originalSlug = $slug;
                        $counter = 1;

                        while (EnsignJobs::where("slug->$lang", $slug)->where('id', '!=', $item->id)->exists()) {
                            $slug = $originalSlug . '-' . $counter;
                            $counter++;
                        }

                        $item->setTranslation('slug', $lang, $slug);
                    }
                }
            }
        });
    }
}
