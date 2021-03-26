<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function ville() {
        return $this->belongsTo(Ville::class);
    }
}
