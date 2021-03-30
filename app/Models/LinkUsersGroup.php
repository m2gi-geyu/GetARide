<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkUsersGroup extends Model
{
    use HasFactory;

    protected $table = 'link_users_groups';
    public $timestamps = false;

    protected $fillable = [
        'id_group',
        'id_member'
    ];
}
