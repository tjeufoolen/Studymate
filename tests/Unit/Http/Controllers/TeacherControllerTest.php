<?php

namespace Tests\Unit;

use App\Http\Controllers\TeacherController;
use App\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class TeacherControllerTest extends TestCase
{
    use RefreshDatabase;
    private $controller;

    public function setUp(): void
    {
        parent::setUp();

        $this->controller = new TeacherController();
    }

    public function testWhen_store_expect_ValidResponseStudentInDatabase()
    {
        //arrange
        $request = Request::create(route('teachers.store'), 'POST', [
            'firstname' => 'John',
            'lastname' => 'Wick',
            'email' => 'J.wick@continental.com'
        ]);

        //act
        $response = $this->controller->store($request);

        //assert
        $student = Teacher::all()->where('firstname', 'John')
            ->where('lastname', 'Wick')
            ->where('email', 'J.wick@continental.com')
            ->first();

        $this->assertNotNull($student);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(route('teachers.index'), $response->getTargetUrl());
    }

    public function testWhen_update_expect_EditedStudentInDatabase()
    {
        //arrange
        $student = Teacher::create([
            'firstname' => 'John',
            'lastname' => 'Wick',
            'email' => 'J.wick@continental.com'
        ]);

        $request = Request::create(route('teachers.update', $student), 'PUT', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'J.doe@gmail.com'
        ]);

        //act
        $response = $this->controller->update($request, $student);

        //assert
        $studentOld = Teacher::all()->where('firstname', 'John')
            ->where('lastname', 'Wick')
            ->where('email', 'J.wick@continental.com')
            ->first();

        $studentNew = Teacher::all()->where('firstname', 'John')
            ->where('lastname', 'Doe')
            ->where('email', 'J.doe@gmail.com')
            ->first();

        $this->assertNotNull($studentNew);
        $this->assertNull($studentOld);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(route('teachers.index'), $response->getTargetUrl());
    }
}
