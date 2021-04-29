<?php

namespace Tests\Unit;

use Modules\Exercise02\Services\ATMService;
use Tests\TestCase;

class AtmFeeTest extends TestCase
{
    private $atmService;

    public function setUp(): void
    {
        parent::setUp();
        $this->atmService = new ATMService();
    }

    /**
     * A vip test.
     *
     * @return void
     */
    public function testVipCustomerTest()
    {
        $fee = $this->atmService->calculateFee(true, '2021-04-29 10:00:00');

        $this->assertEquals(0, $fee);
    }

    /**
     * In holiday and not weekend.
     *
     * @return void
     */
    public function testInHolidayAndNotWeekendTest()
    {
        $fee = $this->atmService->calculateFee(false, '2021-04-30 10:00:00');

        $this->assertEquals(110, $fee);
    }

    /**
     * In not holiday and weekend.
     *
     * @return void
     */
    public function testNotHolidayAndInWeekendTest()
    {
        $fee = $this->atmService->calculateFee(false, '2021-04-25 10:00:00');

        $this->assertEquals(110, $fee);
    }

    /**
     * In not holiday and weekend.
     *
     * @return void
     */
    public function testInHolidayAndInWeekendTest()
    {
        $fee = $this->atmService->calculateFee(false, '2021-05-01 10:00:00');

        $this->assertEquals(110, $fee);
    }

    /**
     * Time is 8:45.
     *
     * @return void
     */
    public function testStartWorkingTimeOfNormalDayTest()
    {
        $fee = $this->atmService->calculateFee(false, '2021-04-29 8:45:00');

        $this->assertEquals(0, $fee);
    }

    /**
     * Time between 8:45 ~ 17:59.
     *
     * @return void
     */
    public function testInWorkingTimeOfNormalDayTest()
    {
        $fee = $this->atmService->calculateFee(false, '2021-04-29 10:00:00');

        $this->assertEquals(0, $fee);
    }

    /**
     * Time is 17:59.
     *
     * @return void
     */
    public function testEndWorkingTimeOfNormalDayTest()
    {
        $fee = $this->atmService->calculateFee(false, '2021-04-29 17:59:00');

        $this->assertEquals(0, $fee);
    }

    /**
     * Time is 00:00.
     *
     * @return void
     */
    public function testStartPeriod1TimeOfNormalDayTest()
    {
        $fee = $this->atmService->calculateFee(false, '2021-04-29 00:00:00');

        $this->assertEquals(110, $fee);
    }

    /**
     * Time is 08:44.
     *
     * @return void
     */
    public function testEndPeriod1TimeOfNormalDayTest()
    {
        $fee = $this->atmService->calculateFee(false, '2021-04-29 08:44:00');

        $this->assertEquals(110, $fee);
    }

    /**
     * Time is 18:00.
     *
     * @return void
     */
    public function testStartPeriod3TimeOfNormalDayTest()
    {
        $fee = $this->atmService->calculateFee(false, '2021-04-29 18:00:00');

        $this->assertEquals(110, $fee);
    }

    /**
     * Time is 23:59.
     *
     * @return void
     */
    public function testEndPeriod3TimeOfNormalDayTest()
    {
        $fee = $this->atmService->calculateFee(false, '2021-04-29 18:59:00');

        $this->assertEquals(110, $fee);
    }
}
