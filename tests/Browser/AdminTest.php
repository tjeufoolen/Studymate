<?php

namespace Tests\Browser;

use App\User;
use Carbon\Carbon;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class AdminTest extends DuskTestCase
{
    /**
     * @var User
     */
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $user = User::firstWhere('name', 'admin');
    }

    /**
     * Tests if the administrator can see its dashboard
     *
     * @return void
     * @throws Throwable
     */
    public function testCanVisitDashboard()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit('/dashboard')
                ->assertPathIs('/dashboard');
        });
    }

    /**
     * Tests if the administrator can see all teachers
     *
     * @return void
     * @throws Throwable
     */
    public function testCanSeeTeachers()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit('/teachers')
                ->assertPathIs('/teachers');
        });
    }

    /**
     * Tests if the administrator can create a new teacher
     *
     * @return void
     * @throws Throwable
     */
    public function testCanCreateTeacher()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit('/teachers')
                ->click('@create')
                ->pause('1000')
                ->assertPathIs('/teachers/create')
                ->type('firstname', 'Voornaam')
                ->type('lastname', 'Achternaam')
                ->type('email', 'email@email.com')
                ->click('button[type="submit"]')
                ->pause('1000')
                ->assertPathIs('/teachers');
        });
    }

    /**
     * Tests if the administrator can delete a teacher
     *
     * @return void
     * @throws Throwable
     */
    public function testCanDeleteTeacher()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit('/teachers')
                ->click('@delete')
                ->pause('1000')
                ->assertPathIs('/teachers');
        });
    }

    /**
     * Tests if the administrator can edit a teacher
     *
     * @return void
     * @throws Throwable
     */
    public function testCanEditTeacher()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit('/teachers')
                ->assertPathIs('/teachers')
                ->click('@edit')
                ->pause('1000')
                ->type('firstname', 'Voornaam')
                ->type('lastname', 'Achternaam')
                ->type('email', 'email@email.com')
                ->click('button[type="submit"]')
                ->pause('1000')
                ->assertPathIs('/teachers');
        });
    }

    /**
     * Tests if the administrator can see all students
     *
     * @return void
     * @throws Throwable
     */
    public function testCanSeeStudents()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit('/students')
                ->assertPathIs('/students');
        });
    }

    /**
     * Tests if the administrator can create a new student
     *
     * @return void
     * @throws Throwable
     */
    public function testCanCreateStudent()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit('/students')
                ->click('@create')
                ->pause('1000')
                ->assertPathIs('/students/create')
                ->type('firstname', 'Voornaam')
                ->type('lastname', 'Achternaam')
                ->type('email', 'email@email.com')
                ->click('button[type="submit"]')
                ->pause('1000')
                ->assertPathIs('/students');
        });
    }

    /**
     * Tests if the administrator can delete a student
     *
     * @return void
     * @throws Throwable
     */
    public function testCanDeleteStudent()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit('/students')
                ->click('@delete')
                ->pause('1000')
                ->assertPathIs('/students');
        });
    }

    /**
     * Tests if the administrator can edit a student
     *
     * @return void
     * @throws Throwable
     */
    public function testCanEditStudent()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit('/students')
                ->assertPathIs('/students')
                ->click('@edit')
                ->pause('1000')
                ->type('firstname', 'Voornaam')
                ->type('lastname', 'Achternaam')
                ->type('email', 'email@email.com')
                ->click('button[type="submit"]')
                ->pause('1000')
                ->assertPathIs('/students');
        });
    }

    /**
     * Tests if the administrator can see all modules
     *
     * @return void
     * @throws Throwable
     */
    public function testCanSeeModules()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit('/modules')
                ->assertPathIs('/modules');
        });
    }

    /**
     * Tests if the administrator can create a new module
     *
     * @return void
     * @throws Throwable
     */
    public function testCanCreateModule()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit('/modules')
                ->click('@create')
                ->pause('1000')
                ->assertPathIs('/modules/create')
                ->type('name', Carbon::now()->timestamp)
                ->type('credits', rand(0, 10))
                ->select('term')
                ->select('test_type')
                ->select('coordinator')
                ->select('teachers[]')
                ->select('teachers[]')
                ->select('teachers[]')
                ->select('tags[]')
                ->select('tags[]')
                ->select('tags[]')
                ->click('button[type="submit"]')
                ->pause('1000')
                ->assertPathIs('/modules');
        });
    }

    /**
     * Tests if the administrator can delete a module
     *
     * @return void
     * @throws Throwable
     */
    public function testCanDeleteModule()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit('/modules')
                ->click('@delete')
                ->pause('1000')
                ->assertPathIs('/modules');
        });
    }

    /**
     * Tests if the administrator can edit a module
     *
     * @return void
     * @throws Throwable
     */
    public function testCanEditModule()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit('/modules')
                ->assertPathIs('/modules')
                ->click('@edit')
                ->pause('1000')
                ->type('name', Carbon::now()->timestamp)
                ->type('credits', rand(0, 10))
                ->select('term')
                ->select('test_type')
                ->select('coordinator')
                ->select('teachers[]')
                ->select('teachers[]')
                ->select('teachers[]')
                ->select('tags[]')
                ->select('tags[]')
                ->select('tags[]')
                ->click('button[type="submit"]')
                ->pause('1000')
                ->assertPathIs('/modules');
        });
    }
}
