<?php

namespace Tests\Browser;

use App\Student;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class DashboardTest extends DuskTestCase
{
    /**
     * @var Student
     */
    private $student;

    public function setUp(): void
    {
        parent::setUp();

        $this->student = Student::first();
    }

    /**
     * Tests if the process of entering a student number will redirect the visitor to the right page
     *
     * @return void
     * @throws Throwable
     */
    public function testSearchingStudentRedirectsToRightPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause('1000')
                ->assertSee('StudyMate')
                ->type('student_number', $this->student->id)
                ->press('Zoeken')
                ->assertPathIs('/students/' . $this->student->id)
                ->assertSee($this->student->name);
        });
    }

    /**
     * Tests if a visual representation of the student progress is visible
     *
     * @return void
     * @throws Throwable
     */
    public function testStudentProgressIsVisible()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/students/' . $this->student->id)
                ->pause('1000')
                ->assertSee('Global study progress')
                ->assertSee('Total achieved credits')
                ->assertSee('Total available credits')
                ->assertPresent('#studyProgressChart');
        });
    }

    /**
     * Tests if visitor can select module by passing in a semester and quarter
     *
     * @return void
     * @throws Throwable
     */
    public function testModuleIsSelectable()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/students/' . $this->student->id)
                ->pause('1000')
                ->assertPresent('select[name="semester"]')
                ->assertPresent('select[name="quarter"]')
                ->assertPresent('select[name="module"]');
        });
    }
}
