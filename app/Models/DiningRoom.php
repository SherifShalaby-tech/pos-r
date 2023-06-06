<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiningRoom extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function dining_tables()
    {
        return $this->hasMany(DiningTable::class);
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
