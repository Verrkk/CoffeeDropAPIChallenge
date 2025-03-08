<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashCalculation extends Model
{
    use HasFactory;

    protected $table = 'cash_calculations';
    protected $primaryKey ='cash_calculations';
    public $timestamps = false;

    protected $fillable = [
        'ristretto',
        'espresso',
        'lungo',
        'amount',
    ];
}
