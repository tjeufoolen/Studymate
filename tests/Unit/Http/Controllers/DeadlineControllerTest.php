<?php

namespace Tests\Unit;

use App\Http\Controllers\DeadlineController;
use App\Module;
use App\Teacher;
use App\Term;
use App\Test;
use App\TestType;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class DeadlineControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var DeadlineController
     */
    private $controller;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh', [
            '--seed' => true
        ]);

        $this->controller = new DeadlineController();
    }

    public function testWhen_store_expect_ModuleTestWithDeadline()
    {
        // arrange
        $module = Module::first();

        $datetime = Carbon::now()->toString();
        $request = Request::create(route('deadlines.store', $module->id), 'POST', [
            'datetime' => $datetime,
        ]);

        // act
        $response = $this->controller->store($request, $module);

        // assert
        $module = Module::all()->find($module->id);

        $this->assertEquals(Carbon::parse($datetime)->timestamp, $module->test->deadline_at->timestamp);
        $this->assertEquals(route('deadlines.nodeadlines'), $response->getTargetUrl());
    }
}
