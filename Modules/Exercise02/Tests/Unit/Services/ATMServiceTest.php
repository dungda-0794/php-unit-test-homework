<?php

namespace Modules\Exercise02\Tests\Unit\Services;

use Tests\TestCase;
use Modules\Exercise02\Services\ATMService;
use Modules\Exercise02\Repositories\ATMRepository;
use Modules\Exercise02\Models\ATM;
use InvalidArgumentException;
use Carbon\Carbon;
use Mockery as m;

class ATMServiceTest extends TestCase
{
    protected $atmService;
    protected $atmRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->atmRepository = m::mock(ATMRepository::class);
        $this->atmService = new ATMService($this->atmRepository);
    }

    public function test_card_id_is_invalid()
    {
        $this->atmRepository->shouldReceive('find')->andreturn([]);
        $this->expectExceptionMessage('Card ID is invalid!');
        $this->expectException(InvalidArgumentException::class);

        $result = $this->atmService->calculate(1);
    }

    public function test_is_vip_customer()
    {
        $atm = m::mock(ATM::class)->makePartial();
        $atm->is_vip = true;
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $result = $this->atmService->calculate(1);

        $this->assertEquals(0, $result);
    }

    public function test_is_holiday()
    {
        $this->test_is_holiday_or_weekend('2021-01-01');
    }

    public function test_is_saturday()
    {
        $this->test_is_holiday_or_weekend('2021-04-24');
    }

    public function test_is_sunday()
    {
        $this->test_is_holiday_or_weekend('2021-04-25');
    }

    protected function test_is_holiday_or_weekend($date)
    {
        $atm = m::mock(ATM::class)->makePartial();
        $atm->is_vip = false;
        Carbon::setTestNow(Carbon::parse($date));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $result = $this->atmService->calculate(1);

        $this->assertEquals(110, $result);
    }

    public function test_normal_day_at_8h44 ()
    {
        $this->test_normal_day_at_time('2021-04-15 08:44:00', 110);
    }

    public function test_normal_day_at_8h45 ()
    {
        $this->test_normal_day_at_time('2021-04-15 08:45:00', 0);
    }

    public function test_normal_day_at_8h46 ()
    {
        $this->test_normal_day_at_time('2021-04-15 08:46:00', 0);
    }

    public function test_normal_day_at_17h58 ()
    {
        $this->test_normal_day_at_time('2021-04-15 17:58:00', 0);
    }

    public function test_normal_day_at_17h59 ()
    {
        $this->test_normal_day_at_time('2021-04-15 17:59:00', 0);
    }

    public function test_normal_day_at_18h00 ()
    {
        $this->test_normal_day_at_time('2021-04-15 18:00:00', 110);
    }

    protected function test_normal_day_at_time($dateTime, $fee)
    {
        $atm = m::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse($dateTime));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $result = $this->atmService->calculate(1);
        $this->assertEquals($fee, $result);
    }
}
