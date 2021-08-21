<?php

namespace Tests\Unit;

use App\Http\Controllers\StudentController;
use App\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class StudentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var StudentController
     */
    private $controller;

    public function setUp(): void
    {
        parent::setUp();

        $this->controller = new StudentController();
    }

    public function testWhen_store_expect_ValidResponseStudentInDatabase()
    {
        //arrange
        $request = Request::create(route('students.store'), 'POST', [
            'firstname' => 'John',
            'lastname' => 'Wick',
            'email' => 'J.wick@continental.com'
        ]);

        //act
        $response = $this->controller->store($request);

        //assert
        $student = Student::all()->where('firstname', 'John')
            ->where('lastname', 'Wick')
            ->where('email', 'J.wick@continental.com')
            ->first();

        $this->assertNotNull($student);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(route('students.index'), $response->getTargetUrl());
    }

    public function testWhen_update_expect_EditedStudentInDatabase()
    {
        //arrange
        $student = Student::create([
            'firstname' => 'John',
            'lastname' => 'Wick',
            'email' => 'J.wick@continental.com'
        ]);

        $request = Request::create(route('students.update', $student), 'PUT', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'J.doe@gmail.com'
        ]);

        //act
        $response = $this->controller->update($request, $student);

        //assert
        $studentOld = Student::all()->where('firstname', 'John')
            ->where('lastname', 'Wick')
            ->where('email', 'J.wick@continental.com')
            ->first();

        $studentNew = Student::all()->where('firstname', 'John')
            ->where('lastname', 'Doe')
            ->where('email', 'J.doe@gmail.com')
            ->first();

        $this->assertNotNull($studentNew);
        $this->assertNull($studentOld);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(route('students.index'), $response->getTargetUrl());
    }
}
