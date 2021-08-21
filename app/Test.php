<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    public $fillable = ['deadline_at', 'test_type_id', 'module_id'];
    protected $dates = ['deadline_at'];

    public function module()
    {
        return $this->hasOne('App\Module');
    }

    public function test_type()
    {
        return $this->belongsTo('App\TestType');
    }
}
