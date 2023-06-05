<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConnectedPrinter extends Model
{
    use HasFactory;
    protected $table = 'connected_printers';

    protected $fillable = [
        'printer_name',
        'html',
    ];
}
