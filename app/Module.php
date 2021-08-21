<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    public $fillable = ['name', 'credits', 'test_id', 'coordinator_id', 'term_id'];

    public function test()
    {
        return $this->hasOne('App\Test');
    }

    public function term()
    {
        return $this->belongsTo('App\Term');
    }

    public function coordinator()
    {
        return $this->belongsTo('App\Teacher', 'coordinator_id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function lectures()
    {
        return $this->hasMany('App\Lecture');
    }

    public function students()
    {
        return Student::whereHas('lectures', function ($x) {
            return $x->WhereHas('module', function ($x) {
                return $x->where('id', $this->id);
            });
        });
    }
}
