<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Auth;
use Spatie\Permission\Traits\HasRoles;



class User extends Authenticatable implements MustVerifyEmailContract
{
    use MustVerifyEmailTrait,HasRoles;

    use Notifiable{
        notify as protected laravelNotify;
    }

    public function notify($instance){

        if ($this->id == Auth::id()) {
            return ;
        }

        if (method_exists($instance , 'toDatabase')) {
            $this->increment('notification_count',1);
        }
        $this->laravelNotify($instance);
    }


    // 清除未读消息标示
    public function markAsRead(){

        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }




    public function topics(){

        
        return $this->hasMany(Topic::class);
    }


    public function replies(){

        return $this->hasMany(Reply::class);
    }



    public function isAuthorOf($model){


        return $this->id === $model->user_id;
    }


    /**
    * 修改器
     */
    public function setPasswordAttribute($value){

        if (strlen($value) != 60){
            $value = bcrypt($value);
        }

        $this->attributes['password'] = $value;
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','introduction'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
