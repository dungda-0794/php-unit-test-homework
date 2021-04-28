<?php

namespace Tests\Unit\Modules\Exercise02\Services;

use Carbon\Carbon;
use InvalidArgumentException;
use Mockery;
use Modules\Exercise02\Models\ATM;
use Modules\Exercise02\Repositories\ATMRepository;
use Modules\Exercise02\Services\ATMService;
use Tests\TestCase;

class ATMServiceTest extends TestCase
{
    protected $atmRepository;
    protected $atmService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->atmRepository = Mockery::mock(ATMRepository::class)->makePartial();
        $this->atmService = new ATMService($this->atmRepository);
    }

    public function test_calculate_invalid_card_id()
    {
        $this->atmRepository->shouldReceive('find')->andReturn(null);
        $this->expectException(InvalidArgumentException::class);

        $this->atmService->calculate(10001);
    }

    public function test_calculate_customer_is_vip_on_holidays_saturday()
    {
        $card = new ATM();
        $card->is_vip = true;
        $this->atmRepository->shouldReceive('find')->andReturn($card);

        Carbon::setTestNow(Carbon::parse('2021-05-01'));

        $fee = $this->atmService->calculate(1001);

        $this->assertEquals(0, $fee);
    }

    public function test_calculate_customer_is_vip_on_holidays_sunday()
    {
        $card = new ATM();
        $card->is_vip = true;
        $this->atmRepository->shouldReceive('find')->andReturn($card);

        Carbon::setTestNow(Carbon::parse('2022-05-01'));

        $fee = $this->atmService->calculate(1001);

        $this->assertEquals(0, $fee);
    }

    public function test_calculate_customer_is_vip_on_holidays_which_is_normal_day_0_00_to_8_44()
    {
        $card = new ATM();
        $card->is_vip = true;
        $this->atmRepository->shouldReceive('find')->andReturn($card);

        Carbon::setTestNow(Carbon::parse('2021-04-30 08:44:00'));

        $fee = $this->atmService->calculate(1001);

        $this->assertEquals(0, $fee);
    }

    public function test_calculate_customer_is_vip_on_holidays_which_is_normal_day_8_45_to_17_59()
    {
        $card = new ATM();
        $card->is_vip = true;
        $this->atmRepository->shouldReceive('find')->andReturn($card);

        Carbon::setTestNow(Carbon::parse('2021-04-30 08:45:00'));

        $fee = $this->atmService->calculate(1001);

        $this->assertEquals(0, $fee);
    }

    public function test_calculate_customer_is_vip_on_holidays_which_is_normal_day_18_00_to_23_59()
    {
        $card = new ATM();
        $card->is_vip = true;
        $this->atmRepository->shouldReceive('find')->andReturn($card);

        Carbon::setTestNow(Carbon::parse('2021-04-30 18:00:00'));

        $fee = $this->atmService->calculate(1001);

        $this->assertEquals(0, $fee);
    }

    public function test_calculate_customer_is_vip_on_normal_day_0_00_to_8_44()
    {
        $card = new ATM();
        $card->is_vip = true;
        $this->atmRepository->shouldReceive('find')->andReturn($card);

        Carbon::setTestNow(Carbon::parse('2021-04-29 08:44:00'));

        $fee = $this->atmService->calculate(1001);

        $this->assertEquals(0, $fee);
    }

    public function test_calculate_customer_is_vip_on_normal_day_8_45_to_17_59()
    {
        $card = new ATM();
        $card->is_vip = true;
        $this->atmRepository->shouldReceive('find')->andReturn($card);

        Carbon::setTestNow(Carbon::parse('2021-04-29 08:45:00'));

        $fee = $this->atmService->calculate(1001);

        $this->assertEquals(0, $fee);
    }

    public function test_calculate_customer_is_vip_on_normal_day_18_00_to_23_59()
    {
        $card = new ATM();
        $card->is_vip = true;
        $this->atmRepository->shouldReceive('find')->andReturn($card);

        Carbon::setTestNow(Carbon::parse('2021-04-29 18:00:00'));

        $fee = $this->atmService->calculate(1001);

        $this->assertEquals(0, $fee);
    }

    public function test_calculate_customer_is_vip_on_saturday()
    {
        $card = new ATM();
        $card->is_vip = true;
        $this->atmRepository->shouldReceive('find')->andReturn($card);

        Carbon::setTestNow(Carbon::parse('2021-04-24'));

        $fee = $this->atmService->calculate(1001);

        $this->assertEquals(0, $fee);
    }

    public function test_calculate_customer_is_vip_on_sunday()
    {
        $card = new ATM();
        $card->is_vip = true;
        $this->atmRepository->shouldReceive('find')->andReturn($card);

        Carbon::setTestNow(Carbon::parse('2021-04-25'));

        $fee = $this->atmService->calculate(1001);

        $this->assertEquals(0, $fee);
    }

    public function test_calculate_customer_is_not_vip_on_holidays_saturday()
    {
        $card = new ATM();
        $card->is_vip = false;
        $this->atmRepository->shouldReceive('find')->andReturn($card);

        Carbon::setTestNow(Carbon::parse('2021-05-01'));

        $fee = $this->atmService->calculate(1001);

        $this->assertEquals(110, $fee);
    }

    public function test_calculate_customer_is_not_vip_on_holidays_sunday()
    {
        $card = new ATM();
        $card->is_vip = false;
        $this->atmRepository->shouldReceive('find')->andReturn($card);

        Carbon::setTestNow(Carbon::parse('2022-05-01'));

        $fee = $this->atmService->calculate(1001);

        $this->assertEquals(110, $fee);
    }

    public function test_calculate_customer_is_not_vip_on_holidays_which_is_normal_day_0_00_to_8_44()
    {
        $card = new ATM();
        $card->is_vip = false;
        $this->atmRepository->shouldReceive('find')->andReturn($card);

        Carbon::setTestNow(Carbon::parse('2021-04-30 08:44:00'));

        $fee = $this->atmService->calculate(1001);

        $this->assertEquals(110, $fee);
    }

    public function test_calculate_customer_is_not_vip_on_holidays_which_is_normal_day_8_45_to_17_59()
    {
        $card = new ATM();
        $card->is_vip = false;
        $this->atmRepository->shouldReceive('find')->andReturn($card);

        Carbon::setTestNow(Carbon::parse('2021-04-30 08:45:00'));

        $fee = $this->atmService->calculate(1001);

        $this->assertEquals(110, $fee);
    }

    public function test_calculate_customer_is_not_vip_on_holidays_which_is_normal_day_18_00_to_23_59()
    {
        $card = new ATM();
        $card->is_vip = false;
        $this->atmRepository->shouldReceive('find')->andReturn($card);

        Carbon::setTestNow(Carbon::parse('2021-04-30 18:00:00'));

        $fee = $this->atmService->calculate(1001);

        $this->assertEquals(110, $fee);
    }

    public function test_calculate_customer_is_not_vip_on_normal_day_0_00_to_8_44()
    {
        $card = new ATM();
        $card->is_vip = false;
        $this->atmRepository->shouldReceive('find')->andReturn($card);

        Carbon::setTestNow(Carbon::parse('2021-04-29 08:44:00'));

        $fee = $this->atmService->calculate(1001);

        $this->assertEquals(110, $fee);
    }

    public function test_calculate_customer_is_not_vip_on_normal_day_8_45_to_17_59()
    {
        $card = new ATM();
        $card->is_vip = false;
        $this->atmRepository->shouldReceive('find')->andReturn($card);

        Carbon::setTestNow(Carbon::parse('2021-04-29 08:45:00'));

        $fee = $this->atmService->calculate(1001);

        $this->assertEquals(0, $fee);
    }

    public function test_calculate_customer_is_not_vip_on_normal_day_18_00_to_23_59()
    {
        $card = new ATM();
        $card->is_vip = false;
        $this->atmRepository->shouldReceive('find')->andReturn($card);

        Carbon::setTestNow(Carbon::parse('2021-04-29 18:00:00'));

        $fee = $this->atmService->calculate(1001);

        $this->assertEquals(110, $fee);
    }

    public function test_calculate_customer_is_not_vip_on_saturday()
    {
        $card = new ATM();
        $card->is_vip = false;
        $this->atmRepository->shouldReceive('find')->andReturn($card);

        Carbon::setTestNow(Carbon::parse('2021-04-24'));

        $fee = $this->atmService->calculate(1001);

        $this->assertEquals(110, $fee);
    }

    public function test_calculate_customer_is_not_vip_on_sunday()
    {
        $card = new ATM();
        $card->is_vip = false;
        $this->atmRepository->shouldReceive('find')->andReturn($card);

        Carbon::setTestNow(Carbon::parse('2021-04-25'));

        $fee = $this->atmService->calculate(1001);

        $this->assertEquals(110, $fee);
    }
}
