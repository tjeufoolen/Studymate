<?php

namespace Tests\Browser;

use App\User;
use Carbon\Carbon;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\DatePicker;
use Tests\DuskTestCase;
use Throwable;

class DeadlineManagerTest extends DuskTestCase
{
    /**
     * Tests if the deadline manager can see its dashboard
     *
     * @return void
     * @throws Throwable
     */
    public function testCanVisitDashboard()
    {
        $user = User::firstWhere('name', 'deadlinemanager');

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                ->visit('/dashboard')
                ->pause('1000')
                ->assertPathIs('/dashboard');
        });
    }

    /**
     * Tests if the deadline manager can see deadlines
     *
     * @return void
     * @throws Throwable
     */
    public function testDeadlinesVisible()
    {
        $user = User::firstWhere('name', 'deadlinemanager');

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                ->visit('/deadlines')
                ->pause('1000')
                ->assertPathIs('/deadlines')
                ->assertSee('Deadlines');
        });
    }

    /**
     * Tests if the deadline manager can see deadline tags
     *
     * @return void
     * @throws Throwable
     */
    public function testDeadlineTagsVisible()
    {
        $user = User::firstWhere('name', 'deadlinemanager');

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                ->visit('/deadlines')
                ->pause('1000')
                ->assertPathIs('/deadlines')
                ->assertSee('Tags');
        });
    }

    /**
     * Tests if the deadline manager can sort deadlines by teacher
     *
     * @return void
     * @throws Throwable
     */
    public function testCanSortDeadlinesByTeachers()
    {
        $user = User::firstWhere('name', 'deadlinemanager');

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                ->visit('/deadlines')
                ->pause('1000')
                ->assertPathIs('/deadlines')
                ->select('sort', 'teacher')
                ->click('button[type="submit"]')
                ->pause('1000')
                ->assertPathIs('/deadlines')
                ->assertSelected('sort', 'teacher');
        });
    }

    /**
     * Tests if the deadline manager can sort deadlines by module
     *
     * @return void
     * @throws Throwable
     */
    public function testCanSortDeadlinesByModule()
    {
        $user = User::firstWhere('name', 'deadlinemanager');

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                ->visit('/deadlines')
                ->pause('1000')
                ->assertPathIs('/deadlines')
                ->select('sort', 'module')
                ->click('button[type="submit"]')
                ->pause('1000')
                ->assertPathIs('/deadlines')
                ->assertSelected('sort', 'module');
        });
    }

    /**
     * Tests if the deadline manager can sort deadlines by deadline
     *
     * @return void
     * @throws Throwable
     */
    public function testCanSortDeadlinesByDeadline()
    {
        $user = User::firstWhere('name', 'deadlinemanager');

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                ->visit('/deadlines')
                ->pause('1000')
                ->assertPathIs('/deadlines')
                ->select('sort', 'deadline')
                ->click('button[type="submit"]')
                ->pause('1000')
                ->assertPathIs('/deadlines')
                ->assertSelected('sort', 'deadline');
        });
    }

    /**
     * Tests if the deadline manager can sort deadlines by deadline
     *
     * @return void
     * @throws Throwable
     */
    public function testCanSortDeadlinesByCategory()
    {
        $user = User::firstWhere('name', 'deadlinemanager');

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                ->visit('/deadlines')
                ->pause('1000')
                ->assertPathIs('/deadlines')
                ->select('sort', 'category')
                ->click('button[type="submit"]')
                ->pause('1000')
                ->assertPathIs('/deadlines')
                ->assertSelected('sort', 'category');
        });
    }

    /**
     * Tests if the deadline manager can schedule a deadline
     *
     * @return void
     * @throws Throwable
     */
    public function testCanScheduleDeadline()
    {
        $user = User::firstWhere('name', 'deadlinemanager');
        $datetime = Carbon::now()->addHour();

        $this->browse(function (Browser $browser) use ($user, $datetime) {
            $browser->loginAs($user->id)
                ->visit('/nodeadlines')
                ->pause('1000')
                ->assertPathIs('/nodeadlines')
                ->assertSee('Schedule')
                ->click('@schedule')
                ->pause('1000')
                ->assertPresent('input[type="datetime-local"]')
                ->within(new DatePicker, function ($browser) use ($datetime) {
                    $browser->selectDate(
                        $datetime->day,
                        $datetime->month,
                        $datetime->year,
                        $datetime->hour,
                        $datetime->minute
                    );
                })
                ->click('button[type="submit"]')
                ->pause('1000')
                ->assertPathIs('/nodeadlines');
        });
    }
}
