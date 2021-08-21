<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    public $fillable = ['module_id', 'teacher_id'];
    public $timestamps = false;
    protected $dates = ['submitted_at', 'graded_at'];

    public function module()
    {
        return $this->belongsTo('App\Module');
    }

    public function teacher()
    {
        return $this->belongsTo('App\Teacher');
    }

    public function students()
    {
        return $this->belongsToMany('App\Student')
            ->withPivot('file', 'grade', 'graded_at', 'submitted_at');
    }
}
