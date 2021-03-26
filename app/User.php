<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'password',
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
        'phone_verified_at' => 'datetime',
    ];

        public function donneur() {
            return $this->hasOne(Donneur::class);
        }
        
        public function organisation() {
            return $this->hasOne(Organisation::class);
        }

        public function events() {
            return $this->hasMany(Event::class);
        }

        public function hasVerifiedPhone() {
            return ! is_null($this->phone_verified_at);
        }

        public function markPhoneAsVerified() {

            return $this->forceFill([
                'phone_verified_at' => $this->freshTimestamp(),
            ])->save();
        
        }
}
