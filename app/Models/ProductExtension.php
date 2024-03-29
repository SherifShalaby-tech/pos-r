<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductExtension extends Model
{
    use HasFactory;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    public function extension(){
        return $this->belongsTo(Extension::class);
    }

    public function variation(){
        return $this->belongsTo(Variation::class);
    }
}
