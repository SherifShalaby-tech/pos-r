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

    public function getCategoryPathAttribute()
    {
//        $category_path = '';
//        if (!is_null($this->parent_id) && $this->parent_id > 0) {
//            $cat = Category::find($this->parent_id);
//            $category_path .= ' - ' . $cat->name;
//            if (!is_null($cat->parent_id) && $cat->parent_id > 0) {
//                $c = Category::find($cat->parent_id);
//                $category_path .= ' - ' . $c->name;
//            }
//        }
        return $this->getSubcategoryPaths($this,[]);
    }


//    ============================  under processing   تحت التصنيع
//    ============================   processed   العمليات المستلمة
    public function getSubcategoryPaths($category, $paths = [], $path = [])
    {
        $path[] = $category->name;

        foreach ($category->children as $child) {
            getSubcategoryPaths($child, $paths, $path);
        }

        $paths[] = $path;
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
}
