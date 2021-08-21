<?php

namespace App;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use Encryptable;
    protected $fillable = ['firstname', 'lastname', 'email'];
    protected $encryptable = ['firstname', 'lastname', 'email'];
    protected $dates = ['submitted_at', 'graded_at'];

    public function getNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getCreditsAttribute()
    {
        return $this->lectures()
            ->wherePivot('grade', '>=', 5.5)
            ->get()
            ->sum('module.credits');
    }

    public function lectures()
    {
        return $this->belongsToMany('App\Lecture')
            ->withPivot('file', 'grade', 'graded_at', 'submitted_at');
    }

    public function modules()
    {
        return Module::whereHas('lectures', function ($x) {
            return $x->whereHas('students', function ($x) {
                return $x->where('id', $this->id);
            });
        });
    }

    public function getAvailableCreditsAttribute()
    {
        return $this->lectures()->get()->sum('module.credits');
    }

    public function completedModules()
    {
        return Module::whereHas('lectures', function ($x) {
            return $x->whereHas('students', function ($x) {
                return $x->where('id', $this->id)
                    ->where('lecture_student.grade', '>=', 5.5);
            });
        });
    }
}
