<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    public function createSlug($title)
    {
        return Str::slug($title, '-');
    }

    protected $fillable = ['title', 'description', 'slug', 'cover_image', 'skills', 'project_link', 'type_id'];


    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    /*     protected function cover_image(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (strstr($value, 'http') !== false) {
                    return $value;
                } else {
                    //dd($value);
                    return asset('storage/' . $value);
                }
            }
        );
    } */
}
