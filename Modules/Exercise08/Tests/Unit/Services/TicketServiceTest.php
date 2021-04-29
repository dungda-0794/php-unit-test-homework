<?php

namespace Modules\Exercise08\Tests\Unit\Services;

use Modules\Exercise08\Services\TicketService;
use InvalidArgumentException;
use Tests\TestCase;


class TicketServiceTest extends TestCase
{
    protected $ticketService;
    protected $model;

    public function setUp(): void
    {
        parent::setUp();

        $this->ticketService = new TicketService();
    }

    public function test_is_negative_age()
    {
        $param = [
            'age' => -1,
            'booking_date' => '',
        ];
        $this->expectExceptionMessage('The age must be from ' . TicketService::MIN_AGE . ' to ' . TicketService::MAX_AGE);
        $this->expectException(InvalidArgumentException::class);

        $this->ticketService->calculatePrice($param);
    }

    public function test_is_age_more_than_120()
    {
        $param = [
            'age' => 121,
            'booking_date' => '',
        ];
        $this->expectExceptionMessage('The age must be from ' . TicketService::MIN_AGE . ' to ' . TicketService::MAX_AGE);
        $this->expectException(InvalidArgumentException::class);

        $this->ticketService->calculatePrice($param);
    }

    public function test_is_age_less_than_13()
    {
        $param = [
            'age' => 12,
            'booking_date' => '',
        ];

        $result = $this->ticketService->calculatePrice($param);
        return $this->assertEquals(TicketService::BASE_PRICE * 0.5, $result);
    }

    public function test_is_age_equal_13()
    {
        $param = [
            'age' => 13,
            'booking_date' => '',
            'gender' => '',
        ];

        $result = $this->ticketService->calculatePrice($param);
        return $this->assertEquals(TicketService::BASE_PRICE, $result);
    }

    public function test_day_is_tuesday()
    {
        $param = [
            'age' => 13,
            'booking_date' => '2021-04-27',
            'gender' => '',
        ];

        $result = $this->ticketService->calculatePrice($param);
        return $this->assertEquals(TicketService::PRICE_IN_TUESDAY, $result);
    }

    public function test_is_woman_and_day_is_not_friday()
    {
        $param = [
            'age' => 13,
            'booking_date' => '2021-04-11',
            'gender' => config('exercise08.gender.female'),
        ];

        $result = $this->ticketService->calculatePrice($param);
        return $this->assertEquals(TicketService::BASE_PRICE, $result);
    }

    public function test_is_not_woman_and_day_is_friday()
    {
        $param = [
            'age' => 13,
            'booking_date' => '2021-04-30',
            'gender' => '',
        ];

        $result = $this->ticketService->calculatePrice($param);
        return $this->assertEquals(TicketService::BASE_PRICE, $result);
    }

    public function test_is_woman_and_day_is_friday()
    {
        $param = [
            'age' => 13,
            'booking_date' => '2021-04-30',
            'gender' => config('exercise08.gender.female'),
        ];

        $result = $this->ticketService->calculatePrice($param);
        return $this->assertEquals(TicketService::PRICE_FEMALE_FRIDAY, $result);
    }

    public function test_is_woman_and_is_friday_and_age_greater_than_65()
    {
        $param = [
            'age' => 66,
            'booking_date' => '2021-04-30',
            'gender' => config('exercise08.gender.female'),
        ];

        $result = $this->ticketService->calculatePrice($param);
        return $this->assertEquals(TicketService::PRICE_FEMALE_FRIDAY, $result);
    }

    public function test_is_age_equal_0()
    {
        $param = [
            'age' => 0,
            'booking_date' => '',
        ];

        $result = $this->ticketService->calculatePrice($param);
        return $this->assertEquals(TicketService::BASE_PRICE * 0.5, $result);
    }

    public function test_is_age_greater_than_65()
    {
        $param = [
            'age' => 66,
            'booking_date' => '2021-04-12',
            'gender' => '',
        ];

        $result = $this->ticketService->calculatePrice($param);
        return $this->assertEquals(TicketService::PRICE_OVER_65, $result);
    }

    public function test_is_age_equal_65()
    {
        $param = [
            'age' => 65,
            'booking_date' => '2021-04-12',
            'gender' => '',
        ];

        $result = $this->ticketService->calculatePrice($param);
        return $this->assertEquals(TicketService::BASE_PRICE, $result);
    }
}
