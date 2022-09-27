<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellLineExtension extends Model
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

    public function sell_line(){
        return $this->belongsTo(TransactionSellLine::class,'transaction_sell_line_id');
    }
}
