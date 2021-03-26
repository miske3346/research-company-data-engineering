<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    public function childs() {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent() {
        return $this->belongsTo(self::class,'parent_id','id');
    }

    public function dons() {
        return $this->hasMany(Don::class);
    }

    public function donneurs() {
        return $this->hasMany(Donneur::class);
    }

    public function events() {
        return $this->hasMany(Event::class);
    }

    public function orgs() {
        return $this->hasMany(Organisation::class);
    }

}
