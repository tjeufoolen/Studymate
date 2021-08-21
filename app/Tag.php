<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $fillable = ['name'];
    public $timestamps = false;

    public function modules()
    {
        return $this->belongsToMany('App\Module');
    }
}
