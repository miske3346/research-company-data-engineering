<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    
   public function dons() {
        return $this->hasMany(Don::class);
    }

    public function donneurs() {
        return $this->hasMany(Donneur::class);
    }

    public function events() {
        return $this->hasMany(Event::class);
    }

}
