<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Laravel\Scout\Searchable;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
use Staudenmeir\EloquentJsonRelations\Relations\BelongsToJson;

class Product extends Model
{
    use HasFactory, HasSlug, Searchable, HasJsonRelationships;

    protected $fillable = [
        'name',
        'slug',
        'attributes',
        'options',
        'category_id',
        'brand_id'
    ];

    protected $casts = [
        'attributes' => IdsCasts::class,
//        'attributes' => 'json',
        'options' => 'json',
    ];

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function attributeValues(): BelongsToJson
    {
        return $this->belongsToJson(AttributeValue::class, 'options');
    }
}
