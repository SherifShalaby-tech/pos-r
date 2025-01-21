<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // RELATIONSHIPS

    public function paymentMethodTypes()
    {
        return $this->hasMany(PaymentMethodType::class);
    }
}
