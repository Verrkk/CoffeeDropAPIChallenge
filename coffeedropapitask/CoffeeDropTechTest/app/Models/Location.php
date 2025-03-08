<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'postcode', 
        'address', 
        'opening_times', 
        'closing_times', 
        'open_monday', 
        'open_tuesday', 
        'open_wednesday', 
        'open_thursday', 
        'open_friday', 
        'open_saturday', 
        'open_sunday', 
        'closed_monday', 
        'closed_tuesday', 
        'closed_wednesday', 
        'closed_thursday', 
        'closed_friday', 
        'closed_saturday', 
        'closed_sunday', 
        'latitude', 
        'longitude',
    ];

    
}
