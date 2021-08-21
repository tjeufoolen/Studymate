<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    public $fillable = ['semester', 'quarter'];
    public $timestamps = false;

    public function getNameAttribute()
    {
        return 'Semester: ' . $this->semester . ' - ' . 'Quarter: ' . $this->quarter;
    }

    public function modules()
    {
        return $this->hasMany('App\Module');
    }
}
