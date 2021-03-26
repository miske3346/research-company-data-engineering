<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function don() {
        return $this->belongsTo(Don::class);
    }
    
}
