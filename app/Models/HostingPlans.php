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
    public $translatable = ['name', 'description','terms_conditions'];
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
            $slug = Str::slug($item->name);
            $originalSlug = $slug;
            $counter = 1;
            // Check if the slug already exists in the database
            while (HostingPlans::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            // Assign the unique slug
            $item->slug = $slug;
        });

        static::updating(function (HostingPlans $item) {

            if ($item->isDirty('name')) { // Check if name is being updated
                $slug = Str::slug($item->name);
                $originalSlug = $slug;
                $counter = 1;
                // Check if the slug already exists, but ignore the current record
                while (HostingPlans::where('slug', $slug)->where('id', '!=', $item->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                // Assign the unique slug
                $item->slug = $slug;
            }
        });
    }
}
