<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionTransaction extends Model
{
    use HasFactory;
    protected $table="production_transaction";

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];


    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
    public function production()
    {
        return $this->belongsTo(Production::class);
    }

}
