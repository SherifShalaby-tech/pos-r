<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    protected $appends = ["category_path"];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'translations' => 'array',
    ];

    public function getNameAttribute($name)
    {
        $translations = !empty($this->translations['name']) ? $this->translations['name'] : [];
        if (!empty($translations)) {
            $lang = session('language');
            if (!empty($translations[$lang])) {
                return $translations[$lang];
            }
        }
        return $name;
    }




    public function getPathAttribute()
    {
        $path = [$this->name]; // Initialize the path with the current category name
        // If the category has a parent, add the parent's path to the current path recursively
        if ($this->parent) {
            $path = array_merge($this->parent->path, $path);
        }

        return $path;
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function productClass()
    {
        return $this->belongsTo(ProductClass::class,'product_class_id');
    }
    public function mainCategory()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
