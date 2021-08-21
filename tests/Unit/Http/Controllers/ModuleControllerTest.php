<?php

namespace Tests\Unit;

use App\Http\Controllers\ModuleController;
use App\Module;
use App\Teacher;
use App\Test;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class ModuleControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var ModuleController
     */
    private $controller;
    /**
     * @var Collection|Model
     */
    private $teacher;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh', [
            '--seed' => true
        ]);

        $this->controller = new ModuleController();
        $this->teacher = factory(Teacher::class)->create([
            'firstname' => 'John',
            'lastname' => 'Wick',
            'email' => 'J.Wick@continental.com'
        ]);
    }

    public function testWhen_store_expect_ValidModuleInDatabase()
    {
        //arrange
        $request = Request::create(route('modules.store'), 'POST', [
            'name' => 'TestModule123',
            'credits' => '5',
            'term' => '1',
            'test_type' => '2',
            'coordinator' => strval($this->teacher->id),
            'teachers' => [strval($this->teacher->id)],
            'tags' => ["1"]
        ]);

        //act
        $response = $this->controller->store($request);

        //assert
        $module = Module::all()
            ->where('name', 'TestModule123')
            ->where('credits', '5')
            ->first();

        $this->assertNotNull($module);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(route('modules.index'), $response->getTargetUrl());
    }


    public function testWhen_update_expect_EditedStudentInDatabase()
    {
        //arrange
        $module = Module::create([
            'name' => 'TestModule123',
            'credits' => '5',
            'term_id' => '1',
            'test_type' => '2',
            'coordinator_id' => strval($this->teacher->id),
            'teachers' => [strval($this->teacher->id)],
            'tags' => ["1"]
        ]);

        Test::create(['test_type_id' => 2, 'deadline_at' => Carbon::now(), 'module_id' => $module->id]);

        $request = Request::create(route('modules.update', $module), 'PUT', [
            'name' => 'NewName',
            'credits' => '9',
            'term' => '1',
            'test_type' => '2',
            'coordinator' => strval($this->teacher->id),
            'teachers' => [strval($this->teacher->id)],
            'tags' => ["1"]
        ]);

        //act
        $response = $this->controller->update($request, $module);

        //assert
        $moduleNew = Module::all()
            ->where('name', 'NewName')
            ->where('credits', '9')
            ->first();

        $moduleOld = Module::all()
            ->where('name', 'TestModule123')
            ->where('credits', '5')
            ->first();

        $this->assertNotNull($moduleNew);
        $this->assertNull($moduleOld);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(route('modules.index'), $response->getTargetUrl());
    }
}
