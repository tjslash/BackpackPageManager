<?php

namespace Tjslash\BackpackPageManager\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\{
    Model,
    SoftDeletes
};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Page extends Model
{
    use CrudTrait, Sluggable, SoftDeletes, HasFactory;

    /**
     * Table name
     * 
     * @var string
     */
    protected $table = 'pages';

    /**
     * Guarded attributes
     * 
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Casts fields
     * 
     * @var array
     */
    protected $casts = [
        'active' => 'boolean'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'title',
                'unique' => true
            ]
        ];
    }

    /**
     * Get route key name for bindings
     * 
     * @return string
     */
    public function getRouteKeyName() : string 
    {
        return 'slug';
    }

    /**
     * Get active pages
     *
     * @param Builder $query
     * 
     * @return Builder
     */
    public function scopeActive(Builder $query) : Builder
    {
        return $query->where('active', true);
    }

    /**
     * Get URL
     * 
     * @return string
     */
    public function getUrlAttribute() : string
    {
        return route('page', $this->attributes['slug']);
    }
}