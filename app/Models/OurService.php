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
            $slug = Str::slug($item->title);
            $originalSlug = $slug;
            $counter = 1;
            // Check if the slug already exists in the database
            while (OurService::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            // Assign the unique slug
            $item->slug = $slug;
        });

        static::updating(function (OurService $item) {
          
            if ($item->isDirty('title')) { // Check if name is being updated
                $slug = Str::slug($item->title);
                $originalSlug = $slug;
                $counter = 1;
                // Check if the slug already exists, but ignore the current record
                while (OurService::where('slug', $slug)->where('id', '!=', $item->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                // Assign the unique slug
                $item->slug = $slug;
            }
        });
    }
}
