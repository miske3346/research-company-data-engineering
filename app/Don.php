<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Don extends Model
{
    protected $guarded = [];

    public function donneur() {
        return $this->belongsTo(Donneur::class);
    }

    public function group() {
        return $this->belongsTo(Group::class);
    }

    public function ville() {
        return $this->belongsTo(Ville::class);
    }

    public function alerts() {
        return $this->hasMany(Notification::class);
    }

}
