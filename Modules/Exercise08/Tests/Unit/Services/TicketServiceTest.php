<?php

namespace Tests\Unit\Modules\Exercise08\Services;

use Modules\Exercise08\Services\TicketService;
use Tests\TestCase;
use InvalidArgumentException;

class TicketServiceTest extends TestCase
{

    protected $ticketService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ticketService = new TicketService();
    }

    public function test_invalid_age_lower_than_0() {
         $input = [
             'booking_date' => '2021-05-02',
             'age' => -1
         ];
         $this->expectException(InvalidArgumentException::class);

         $this->ticketService->calculatePrice($input);
    }

    public function test_invalid_age_greater_than_120() {
        $input = [
            'booking_date' => '2021-05-02',
            'age' => 122
        ];
        $this->expectException(InvalidArgumentException::class);

        $this->ticketService->calculatePrice($input);
    }

    public function test_age_valid_and_lower_13() {
        $input = [
            'booking_date' => '2021-05-02',
            'age' => 12
        ];

        $result = $this->ticketService->calculatePrice($input);

        $this->assertEquals(900, $result);
    }

    public function test_booking_date_in_tuesday() {
        $input = [
            'booking_date' => '2021-05-04',
            'age' => 50
        ];

        $result = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1200, $result);
    }

    public function test_age_valid_and_greater_than_65() {
        $input = [
            'booking_date' => '2021-05-05',
            'age' => 66,
            'gender' => 'male'
        ];

        $result = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1600, $result);
    }

    public function test_booking_date_in_friday_and_female() {
        $input = [
            'booking_date' => '2021-05-07',
            'age' => 50,
            'gender' => 'female'
        ];

        $result = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1400, $result);
    }
}
