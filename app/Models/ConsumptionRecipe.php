<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumptionRecipe extends Model
{
    use HasFactory;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function raw_material()
    {
        return $this->belongsTo(Product::class, 'raw_material_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
