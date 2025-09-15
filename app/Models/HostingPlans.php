<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Str;

class HostingPlans extends Model
{
    use HasFactory, HasTranslations,  SoftDeletes;
    public $translatable = ['name', 'description', 'terms_conditions', 'slug'];
    protected $fillable = [
        'name',
        'slug',
        'description',
        'terms_conditions',
        'price',
        'currency',
        'billing_cycle',
        'email_accounts',
        'storage',
        'bandwidth',
        'free_domain',
        'is_most_popular',
        'service_id',
        'slug'
    ];

    protected $casts = [
        'is_most_popular' => 'boolean',
    ];
    public function service()
    {
        return $this->belongsTo(OurService::class);
    }
  protected static function booted(): void
    {
        static::creating(function (HostingPlans $item) {

            foreach (['ar', 'en'] as $lang) {
                // إذا المستخدم لم يدخل slug
                $slug = $item->getTranslation('slug', $lang);
                if (!$slug) {
                    $title = $item->getTranslation('title', $lang) ?? '';
                    if ($title) {
                        $slug = Str::slug($title);

                        $originalSlug = $slug;
                        $counter = 1;

                        while (HostingPlans::where("slug->$lang", $slug)->exists()) {
                            $slug = $originalSlug . '-' . $counter;
                            $counter++;
                        }

                        $item->setTranslation('slug', $lang, $slug);
                    }
                }
            }
        });

        static::updating(function (HostingPlans $item) {

            foreach (['ar', 'en'] as $lang) {
                // إذا المستخدم لم يدخل slug
                $slug = $item->getTranslation('slug', $lang);
                if (!$slug) {
                    $title = $item->getTranslation('title', $lang) ?? '';
                    if ($title) {
                        $slug = Str::slug($title);

                        $originalSlug = $slug;
                        $counter = 1;

                        while (HostingPlans::where("slug->$lang", $slug)->where('id', '!=', $item->id)->exists()) {
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
