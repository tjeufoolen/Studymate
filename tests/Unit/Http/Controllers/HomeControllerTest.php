<?php

namespace Tests\Unit;

use App\Http\Controllers\HomeController;
use App\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var HomeController
     */
    private $controller;


    public function setUp(): void
    {
        parent::setUp();

        $this->controller = new HomeController();
    }

    public function testWhen_index_expect_validatePassesWithValidStudentId()
    {
        //arrange
        $student = factory(Student::class)->create();
        $request = Request::create(route('home'), 'GET', ['student_number' => strval($student->id)]);

        //act
        $response = $this->controller->index($request);

        //assert
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(route('students.show', $student), $response->getTargetUrl());
    }
}
