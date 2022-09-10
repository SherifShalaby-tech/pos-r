<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];


    public function scopeActive($query)
    {
        $query->where('active', 1);
    }
    public function scopeNotActive($query)
    {
        $query->where('active', 0);
    }
    public function consumption_products()
    {
        return $this->hasMany(ConsumptionProduction::class, 'production_id', 'id');
    }
    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id', 'id');
    }

}
