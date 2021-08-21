<?php

namespace App;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use Encryptable;

    public $fillable = ['firstname', 'lastname', 'email'];
    protected $encryptable = ['firstname', 'lastname', 'email'];

    public function getNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function lectures()
    {
        return $this->hasMany('App\Lecture');
    }
}
