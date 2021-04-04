<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $table = 'trips';
    public $timestamps = false;

    protected $fillable = [
        'number_of_seats',
        'starting_town',
        'ending_town',
        'date_trip',
        'precision',
        'price',
        'private',
        'description',
        'id_group'
        ];

}
