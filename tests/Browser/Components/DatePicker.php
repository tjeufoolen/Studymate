<?php

namespace Tests\Browser\Components;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class DatePicker extends BaseComponent
{
    /**
     * Get the root selector for the component.
     *
     * @return string
     */
    public function selector()
    {
        return '.datetimepicker';
    }

    /**
     * Assert that the browser page contains the component.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertVisible($this->selector());
    }

    /**
     * Get the element shortcuts for the component.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@field' => 'datetime',
            '@input' => 'input[type="datetime-local"]',
        ];
    }

    /**
     * Select the given date.
     *
     * @param Browser $browser
     * @param string $day
     * @param string $month
     * @param string $year
     * @param string $hour
     * @param string $minutes
     * @return void
     */
    public function selectDate($browser, $day="01", $month="01", $year="2020", $hour="12", $minutes="00")
    {
        $browser->type('@field', $day)
                ->type('@field', $month)
                ->type('@field', $year)
                ->keys('@input', ['{tab}'])
                ->type('@field', $hour)
                ->type('@field', $minutes);
    }
}
