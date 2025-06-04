<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ['code', 'original_url'];

    public function clicks(){
        return $this->hasMany(Click::class);
    }
}
