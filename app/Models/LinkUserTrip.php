<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkUserTrip extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = 'link_user_trip';
    public $timestamps = false;

    protected $fillable = [
        'id_trip',
        'id_user',
        'validated'
    ];
}
