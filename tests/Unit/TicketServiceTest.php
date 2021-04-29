<?php

namespace Tests\Unit;

use Modules\Exercise08\Services\TicketService;
use Tests\TestCase;
use InvalidArgumentException;

class TicketServiceTest extends TestCase
{
    private $ticketService;

    public function setUp(): void
    {
        parent::setUp();
        $this->ticketService = new TicketService();
    }

    /**
     * Age less than 0
     *
     * @return void
     */
    public function testAgeLessThanMinAgeExceptionTest()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The age must be from 0 to 120');

        $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-29',
            'age' => -1
        ]);
    }

    /**
     * Age greater than 120
     *
     * @return void
     */
    public function testAgeGreaterThanMinAgeExceptionTest()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The age must be from 0 to 120');

        $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-29',
            'age' => 121
        ]);
    }

    /**
     * Age equals to 0
     *
     * @return void
     */
    public function testAgeEqualsToMinAgeTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-29',
            'age' => 0
        ]);

        $this->assertEquals(900, $price);
    }

    /**
     * 0 < age < 13
     *
     * @return void
     */
    public function testAgeLessThan13Test()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-29',
            'age' => 7
        ]);

        $this->assertEquals(900, $price);
    }

    /**
     * Man age = 13 in tuesday
     *
     * @return void
     */
    public function testMan13AgeAndInTuesdayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-27',
            'age' => 13,
            'gender' => config('exercise08.gender.male')
        ]);

        $this->assertEquals(1200, $price);
    }

    /**
     * women age = 13 in tuesday
     *
     * @return void
     */
    public function testWomen13AgeAndInTuesdayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-27',
            'age' => 13,
            'gender' => config('exercise08.gender.female')
        ]);

        $this->assertEquals(1200, $price);
    }

    /**
     * Man age = 13 in friday
     *
     * @return void
     */
    public function testMan13AgeAndInFridayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-30',
            'age' => 13,
            'gender' => config('exercise08.gender.male')
        ]);

        $this->assertEquals(1800, $price);
    }

    /**
     * Women age = 13 in friday
     *
     * @return void
     */
    public function testWomen13AgeAndInFridayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-30',
            'age' => 13,
            'gender' => config('exercise08.gender.female')
        ]);

        $this->assertEquals(1400, $price);
    }

    /**
     * man age = 13 in normal day
     *
     * @return void
     */
    public function testMan13AgeAndInNormalDayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-29',
            'age' => 13,
            'gender' => config('exercise08.gender.male')
        ]);

        $this->assertEquals(1800, $price);
    }

    /**
     * Women age = 13 in friday
     *
     * @return void
     */
    public function testWomen13AgeAndInNormalDayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-29',
            'age' => 13,
            'gender' => config('exercise08.gender.female')
        ]);

        $this->assertEquals(1800, $price);
    }

    /**
     * Man has 13 < age < 65 in tuesday
     *
     * @return void
     */
    public function testMan30AgeAndInTuesdayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-27',
            'age' => 30,
            'gender' => config('exercise08.gender.male')
        ]);

        $this->assertEquals(1200, $price);
    }

    /**
     * Women has 13 < age < 65 in tuesday
     *
     * @return void
     */
    public function testWomen30AgeAndInTuesdayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-27',
            'age' => 30,
            'gender' => config('exercise08.gender.female')
        ]);

        $this->assertEquals(1200, $price);
    }

    /**
     * Man has 13 < age < 65 in friday
     *
     * @return void
     */
    public function testMan30AgeAndInFridayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-30',
            'age' => 30,
            'gender' => config('exercise08.gender.male')
        ]);

        $this->assertEquals(1800, $price);
    }

    /**
     * Women has 13 < age < 65 in friday
     *
     * @return void
     */
    public function testWomen30AgeAndInFridayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-30',
            'age' => 30,
            'gender' => config('exercise08.gender.female')
        ]);

        $this->assertEquals(1400, $price);
    }

    /**
     * Man has 13 < age < 65  in normal day
     *
     * @return void
     */
    public function testMan30AgeAndInNormalDayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-29',
            'age' => 30,
            'gender' => config('exercise08.gender.male')
        ]);

        $this->assertEquals(1800, $price);
    }

    /**
     * Women has 13 < age < 65 in normal day
     *
     * @return void
     */
    public function testWomen30AgeAndInNormalDayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-29',
            'age' => 30,
            'gender' => config('exercise08.gender.female')
        ]);

        $this->assertEquals(1800, $price);
    }

    /**
     * Man has age = 65 in tuesday
     *
     * @return void
     */
    public function testMan65AgeAndInTuesdayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-27',
            'age' => 65,
            'gender' => config('exercise08.gender.male')
        ]);

        $this->assertEquals(1200, $price);
    }

    /**
     * Women has age = 65 in tuesday
     *
     * @return void
     */
    public function testWomen65AgeAndInTuesdayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-27',
            'age' => 65,
            'gender' => config('exercise08.gender.female')
        ]);

        $this->assertEquals(1200, $price);
    }

    /**
     * Man has age = 65  in friday
     *
     * @return void
     */
    public function testMan65AgeAndInFridayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-30',
            'age' => 65,
            'gender' => config('exercise08.gender.male')
        ]);

        $this->assertEquals(1800, $price);
    }

    /**
     * Women has age = 65 in friday
     *
     * @return void
     */
    public function testWomen65AgeAndInFridayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-30',
            'age' => 65,
            'gender' => config('exercise08.gender.female')
        ]);

        $this->assertEquals(1400, $price);
    }

    /**
     * Man has age = 65 in normal day
     *
     * @return void
     */
    public function testMan65AgeAndInNormalDayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-29',
            'age' => 65,
            'gender' => config('exercise08.gender.male')
        ]);

        $this->assertEquals(1800, $price);
    }

    /**
     * Women has age = 65 in normal day
     *
     * @return void
     */
    public function testWomen65AgeAndInNormalDayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-29',
            'age' => 65,
            'gender' => config('exercise08.gender.female')
        ]);

        $this->assertEquals(1800, $price);
    }

    /**
     * Man has 65 < age < 120 in tuesday
     *
     * @return void
     */
    public function testMan80AgeAndInTuesdayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-27',
            'age' => 80,
            'gender' => config('exercise08.gender.male')
        ]);

        $this->assertEquals(1200, $price);
    }

    /**
     * Women has 65 < age < 120 in tuesday
     *
     * @return void
     */
    public function testWomen80AgeAndInTuesdayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-27',
            'age' => 80,
            'gender' => config('exercise08.gender.female')
        ]);

        $this->assertEquals(1200, $price);
    }

    /**
     * Man has 65 < age < 120 in friday
     *
     * @return void
     */
    public function testMan80AgeAndInFridayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-30',
            'age' => 80,
            'gender' => config('exercise08.gender.male')
        ]);

        $this->assertEquals(1600, $price);
    }

    /**
     * Women has 65 < age < 120 in friday
     *
     * @return void
     */
    public function testWomen80AgeAndInFridayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-30',
            'age' => 80,
            'gender' => config('exercise08.gender.female')
        ]);

        $this->assertEquals(1400, $price);
    }

    /**
     * Man has 65 < age < 120 in normal day
     *
     * @return void
     */
    public function testMan80AgeAndInNormalTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-29',
            'age' => 80,
            'gender' => config('exercise08.gender.male')
        ]);

        $this->assertEquals(1600, $price);
    }

    /**
     * women has 65 < age < 120 in normal day
     *
     * @return void
     */
    public function testWomen80AgeAndInNormaldayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-29',
            'age' => 80,
            'gender' => config('exercise08.gender.female')
        ]);

        $this->assertEquals(1600, $price);
    }

    /**
     * Man has age = 120 in tuesday
     *
     * @return void
     */
    public function testMan120AgeAndInTuesday()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-27',
            'age' => 120,
            'gender' => config('exercise08.gender.male')
        ]);

        $this->assertEquals(1200, $price);
    }

    /**
     * Women has age = 120 in tuesday
     *
     * @return void
     */
    public function testWomen120AgeAndInTuesdayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-27',
            'age' => 120,
            'gender' => config('exercise08.gender.female')
        ]);

        $this->assertEquals(1200, $price);
    }

    /**
     * Man has age = 120 in friday
     *
     * @return void
     */
    public function testMan120AgeAndInFriday()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-30',
            'age' => 120,
            'gender' => config('exercise08.gender.male')
        ]);

        $this->assertEquals(1600, $price);
    }

    /**
     * Women has age = 120 in friday
     *
     * @return void
     */
    public function testWomen120AgeAndInFridayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-30',
            'age' => 120,
            'gender' => config('exercise08.gender.female')
        ]);

        $this->assertEquals(1400, $price);
    }

    /**
     * Man has age = 120 in normal day
     *
     * @return void
     */
    public function testMan120AgeAndInNormalDay()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-29',
            'age' => 120,
            'gender' => config('exercise08.gender.male')
        ]);

        $this->assertEquals(1600, $price);
    }

    /**
     * Women has age = 120 in normal day
     *
     * @return void
     */
    public function testWomen120AgeAndInNormalDayTest()
    {
        $price = $this->ticketService->calculatePrice([
            'booking_date' => '2021-04-29',
            'age' => 120,
            'gender' => config('exercise08.gender.female')
        ]);

        $this->assertEquals(1600, $price);
    }
}
