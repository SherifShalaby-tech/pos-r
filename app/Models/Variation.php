<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault(['name' => '']);
    }

    public function color()
    {
        return $this->belongsTo(Color::class)->withDefault(['name' => '']);
    }

    public function size()
    {
        return $this->belongsTo(Size::class)->withDefault(['name' => '']);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class)->withDefault(['name' => '']);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class)->withDefault(['name' => '']);
    }

    public function product_stores()
    {
        return $this->hasMany(ProductStore::class, 'variation_id');
    }
    public function product_extensions()
    {
        return $this->hasMany(ProductExtension::class,'variation_id');
    }
    public function raw_materials()
    {
        return $this->hasMany(ConsumptionProduct::class);
    }
    public function stockLines()
    {
        return $this->hasMany(AddStockLine::class,'variation_id');
    }

    public function getSellPriceAttribute($value)
    {
        $quantityDiffrenceInLineStock = $this->stockLines()->where('quantity',">",'quantity_sold')->first();
        if(is_null($quantityDiffrenceInLineStock))
        {
            return isset($this->default_sell_price)?$this->default_sell_price:$value;
        }
        return $quantityDiffrenceInLineStock->sell_price;
    }
}
