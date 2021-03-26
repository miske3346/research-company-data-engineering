<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donneur extends Model
{

    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    } 

    public function group() {
        return $this->belongsTo(Group::class);
    }

    public function organisation() {
        return $this->belongsTo(Organisation::class);
    }

    public function ville() {
        return $this->belongsTo(Ville::class);
    }

    public function dons() {
        return $this->hasMany(Don::class);
    }

}
