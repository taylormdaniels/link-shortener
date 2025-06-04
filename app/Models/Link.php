<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ['slug', 'original_url'];

    public function clicks(){
        return $this->hasMany(Click::class);
    }
}
