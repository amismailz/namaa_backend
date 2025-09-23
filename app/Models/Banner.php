<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;
use Spatie\Activitylog\Traits\LogsActivity;

class Banner extends Model
{
    use HasFactory, HasTranslations,  SoftDeletes;

    public $translatable = ['title', 'description'];
    protected $fillable = [
        'title',
        'description',
        'image',
        'years_of_experience',
        'completed_projects'
    ];
}
