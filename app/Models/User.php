<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\Security\PasswordResetNotification;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\notifications;



class User extends Authenticatable implements MustVerifyEmail
{


    use HasFactory, Notifiable;


    public $timestamps = false; //thanks StackOverflow!!!!
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'phone',
        'vehicle',
        'ratings',
        'about',
        'profile_pic',
        'mail_notifications',
        'ratings',
        'gender',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {

        $this->notify(new PasswordResetNotification($token));

    }

    /**
     * get array of all notification where the destinated user is $this user
     */
    public function getNotification()
    {
        return  $this->notifications;
    }

    /**
     * Update the table notification, for a notification given we change the field read to 1 to say 'it is read'
     */
    public function readNotification($idNotification)
    {
        DB::table('notifications')
              ->where('id','=', idNotification)
              ->update(['read' => 1]);
    }

}
