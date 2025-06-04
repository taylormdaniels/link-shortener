<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    public function clicks(){
        return $this->hasMany(Click::class);
    }
}
