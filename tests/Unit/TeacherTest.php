<?php

namespace Tests\Unit;

use App\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherTest extends TestCase
{
    use RefreshDatabase;

    public function testWhen_getNameAttribute_Expect_FullNameGiven()
    {
        //arrange
        $student = factory(Teacher::class)->create(['firstname'=>'John', 'lastname'=>'Smith']);

        //act
        $fullname = $student->getNameAttribute();

        //assert
        $this->assertEquals($fullname, 'John Smith');
    }
}
