<?php

namespace Tests\Unit\Modules\Exercise08\Services;

use InvalidArgumentException;
use Modules\Exercise08\Services\TicketService;
use Tests\TestCase;

class TicketServiceTest extends TestCase
{
    protected $ticketService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ticketService = new TicketService();
    }

    public function test_calculate_price_age_lower_than_0()
    {
        $input = [
            'age' => -1,
            'booking_date' => '2021-01-01',
            'gender' => 'male',
            'name' => 'linh',
        ];
        $this->expectException(InvalidArgumentException::class);

        $this->ticketService->calculatePrice($input);
    }

    public function test_calculate_price_age_bigger_than_120()
    {
        $input = [
            'age' => 121,
            'booking_date' => '2021-01-01',
            'gender' => 'male',
            'name' => 'linh',
        ];
        $this->expectException(InvalidArgumentException::class);

        $this->ticketService->calculatePrice($input);
    }

    public function test_calculate_price_age_0_male_go_on_friday()
    {
        $input = [
            'age' => 0,
            'booking_date' => '2021-04-30',
            'gender' => 'male',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(900, $price);
    }

    public function test_calculate_price_age_0_male_go_on_tuesday()
    {
        $input = [
            'age' => 0,
            'booking_date' => '2021-05-04',
            'gender' => 'male',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(900, $price);
    }

    public function test_calculate_price_age_0_male_go_on_regular_day()
    {
        $input = [
            'age' => 0,
            'booking_date' => '2021-05-05',
            'gender' => 'male',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(900, $price);
    }

    public function test_calculate_price_age_0_female_go_on_friday()
    {
        $input = [
            'age' => 0,
            'booking_date' => '2021-04-30',
            'gender' => 'female',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(900, $price);
    }

    public function test_calculate_price_age_0_female_go_on_tuesday()
    {
        $input = [
            'age' => 0,
            'booking_date' => '2021-05-04',
            'gender' => 'female',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(900, $price);
    }

    public function test_calculate_price_age_0_female_go_on_regular_day()
    {
        $input = [
            'age' => 0,
            'booking_date' => '2021-05-05',
            'gender' => 'female',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(900, $price);
    }

    public function test_calculate_price_age_bigger_than_0_and_lower_than_13_male_go_on_friday()
    {
        $input = [
            'age' => 5,
            'booking_date' => '2021-04-30',
            'gender' => 'male',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(900, $price);
    }

    public function test_calculate_price_age_bigger_than_0_and_lower_than_13_male_go_on_tuesday()
    {
        $input = [
            'age' => 5,
            'booking_date' => '2021-05-04',
            'gender' => 'male',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(900, $price);
    }

    public function test_calculate_price_age_bigger_than_0_and_lower_than_13_male_go_on_regular_day()
    {
        $input = [
            'age' => 5,
            'booking_date' => '2021-05-05',
            'gender' => 'male',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(900, $price);
    }

    public function test_calculate_price_age_bigger_than_0_and_lower_than_13_female_go_on_friday()
    {
        $input = [
            'age' => 5,
            'booking_date' => '2021-04-30',
            'gender' => 'female',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(900, $price);
    }

    public function test_calculate_price_age_bigger_than_0_and_lower_than_13_female_go_on_tuesday()
    {
        $input = [
            'age' => 5,
            'booking_date' => '2021-05-04',
            'gender' => 'female',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(900, $price);
    }

    public function test_calculate_price_age_bigger_than_0_and_lower_than_13_female_go_on_regular_day()
    {
        $input = [
            'age' => 5,
            'booking_date' => '2021-05-05',
            'gender' => 'female',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(900, $price);
    }

    public function test_calculate_price_age_13_male_go_on_friday()
    {
        $input = [
            'age' => 13,
            'booking_date' => '2021-04-30',
            'gender' => 'male',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1800, $price);
    }

    public function test_calculate_price_age_13_male_go_on_tuesday()
    {
        $input = [
            'age' => 13,
            'booking_date' => '2021-05-04',
            'gender' => 'male',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1200, $price);
    }

    public function test_calculate_price_age_13_male_go_on_regular_day()
    {
        $input = [
            'age' => 13,
            'booking_date' => '2021-05-05',
            'gender' => 'male',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1800, $price);
    }

    public function test_calculate_price_age_13_female_go_on_friday()
    {
        $input = [
            'age' => 13,
            'booking_date' => '2021-04-30',
            'gender' => 'female',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1400, $price);
    }

    public function test_calculate_price_age_13_female_go_on_tuesday()
    {
        $input = [
            'age' => 13,
            'booking_date' => '2021-05-04',
            'gender' => 'female',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1200, $price);
    }

    public function test_calculate_price_age_13_female_go_on_regular_day()
    {
        $input = [
            'age' => 13,
            'booking_date' => '2021-05-05',
            'gender' => 'female',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1800, $price);
    }

    public function test_calculate_price_age_bigger_than_13_and_lower_than_65_male_go_on_friday()
    {
        $input = [
            'age' => 30,
            'booking_date' => '2021-04-30',
            'gender' => 'male',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1800, $price);
    }

    public function test_calculate_price_age_bigger_than_13_and_lower_than_65_male_go_on_tuesday()
    {
        $input = [
            'age' => 30,
            'booking_date' => '2021-05-04',
            'gender' => 'male',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1200, $price);
    }

    public function test_calculate_price_age_bigger_than_13_and_lower_than_65_male_go_on_regular_day()
    {
        $input = [
            'age' => 30,
            'booking_date' => '2021-05-05',
            'gender' => 'male',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1800, $price);
    }

    public function test_calculate_price_age_bigger_than_13_and_lower_than_65_female_go_on_friday()
    {
        $input = [
            'age' => 30,
            'booking_date' => '2021-04-30',
            'gender' => 'female',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1400, $price);
    }

    public function test_calculate_price_age_bigger_than_13_and_lower_than_65_female_go_on_tuesday()
    {
        $input = [
            'age' => 30,
            'booking_date' => '2021-05-04',
            'gender' => 'female',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1200, $price);
    }

    public function test_calculate_price_age_bigger_than_13_and_lower_than_65_female_go_on_regular_day()
    {
        $input = [
            'age' => 30,
            'booking_date' => '2021-05-05',
            'gender' => 'female',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1800, $price);
    }

    public function test_calculate_price_age_65_male_go_on_friday()
    {
        $input = [
            'age' => 65,
            'booking_date' => '2021-04-30',
            'gender' => 'male',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1800, $price);
    }

    public function test_calculate_price_age_65_male_go_on_tuesday()
    {
        $input = [
            'age' => 65,
            'booking_date' => '2021-05-04',
            'gender' => 'male',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1200, $price);
    }

    public function test_calculate_price_age_65_male_go_on_regular_day()
    {
        $input = [
            'age' => 65,
            'booking_date' => '2021-05-05',
            'gender' => 'male',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1800, $price);
    }

    public function test_calculate_price_age_65_female_go_on_friday()
    {
        $input = [
            'age' => 65,
            'booking_date' => '2021-04-30',
            'gender' => 'female',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1400, $price);
    }

    public function test_calculate_price_age_65_female_go_on_tuesday()
    {
        $input = [
            'age' => 65,
            'booking_date' => '2021-05-04',
            'gender' => 'female',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1200, $price);
    }

    public function test_calculate_price_age_65_female_go_on_regular_day()
    {
        $input = [
            'age' => 65,
            'booking_date' => '2021-05-05',
            'gender' => 'female',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1800, $price);
    }

    public function test_calculate_price_age_bigger_than_65_and_lower_than_120_male_go_on_friday()
    {
        $input = [
            'age' => 80,
            'booking_date' => '2021-04-30',
            'gender' => 'male',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1600, $price);
    }

    public function test_calculate_price_age_bigger_than_65_and_lower_than_120_male_go_on_tuesday()
    {
        $input = [
            'age' => 80,
            'booking_date' => '2021-05-04',
            'gender' => 'male',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1200, $price);
    }

    public function test_calculate_price_age_bigger_than_65_and_lower_than_120_male_go_on_regular_day()
    {
        $input = [
            'age' => 80,
            'booking_date' => '2021-05-05',
            'gender' => 'male',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1600, $price);
    }

    public function test_calculate_price_age_bigger_than_65_and_lower_than_120_female_go_on_friday()
    {
        $input = [
            'age' => 80,
            'booking_date' => '2021-04-30',
            'gender' => 'female',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1400, $price);
    }

    public function test_calculate_price_age_bigger_than_65_and_lower_than_120_female_go_on_tuesday()
    {
        $input = [
            'age' => 80,
            'booking_date' => '2021-05-04',
            'gender' => 'female',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1200, $price);
    }

    public function test_calculate_price_age_bigger_than_65_and_lower_than_120_female_go_on_regular_day()
    {
        $input = [
            'age' => 80,
            'booking_date' => '2021-05-05',
            'gender' => 'female',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1600, $price);
    }

    public function test_calculate_price_age_120_male_go_on_friday()
    {
        $input = [
            'age' => 120,
            'booking_date' => '2021-04-30',
            'gender' => 'male',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1600, $price);
    }

    public function test_calculate_price_age_120_male_go_on_tuesday()
    {
        $input = [
            'age' => 120,
            'booking_date' => '2021-05-04',
            'gender' => 'male',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1200, $price);
    }

    public function test_calculate_price_age_120_male_go_on_regular_day()
    {
        $input = [
            'age' => 120,
            'booking_date' => '2021-05-05',
            'gender' => 'male',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1600, $price);
    }

    public function test_calculate_price_age_120_female_go_on_friday()
    {
        $input = [
            'age' => 120,
            'booking_date' => '2021-04-30',
            'gender' => 'female',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1400, $price);
    }

    public function test_calculate_price_age_120_female_go_on_tuesday()
    {
        $input = [
            'age' => 120,
            'booking_date' => '2021-05-04',
            'gender' => 'female',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1200, $price);
    }

    public function test_calculate_price_age_120_female_go_on_regular_day()
    {
        $input = [
            'age' => 120,
            'booking_date' => '2021-05-05',
            'gender' => 'female',
            'name' => 'linh',
        ];

        $price = $this->ticketService->calculatePrice($input);

        $this->assertEquals(1600, $price);
    }
}
