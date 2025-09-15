<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Faq extends Model
{
    use HasFactory,  SoftDeletes, HasTranslations;
    protected $fillable = [
        'question',
        'answer',
        'is_published',
        'blog_id',
    ];
    public $translatable = ['question', 'answer'];
}
