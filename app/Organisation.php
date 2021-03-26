<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    } 

    public function donneurs() {
        return $this->hasMany(Donneur::class);
    }

    public function ville() {
        return $this->belongsTo(Ville::class);
    }
}
