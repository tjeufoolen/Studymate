<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestType extends Model
{
    public static $ASSESSMENT = "assessment";
    public static $EXAMINATION = "examination";
    public $fillable = ['name'];
    public $timestamps = false;

    public function tests()
    {
        return $this->belongsToMany('App\tests');
    }
}
