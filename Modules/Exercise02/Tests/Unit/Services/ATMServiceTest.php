<?php

namespace Modules\Exercise02\Tests\Unit\Services;

use Tests\TestCase;
use Modules\Exercise02\Services\ATMService;
use Modules\Exercise02\Repositories\ATMRepository;
use Mockery as m;
use Modules\Exercise02\Models\ATM;
use InvalidArgumentException;
use Carbon\Carbon;

class ATMRepositoryTest extends TestCase
{
    protected $atmService;
    protected $atmRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->atmRepository = m::mock(ATMRepository::class);
        $this->atmService = new ATMService($this->atmRepository);
    }

    public function test_without_card()
    {
        $this->atmRepository->shouldReceive('find')->andreturn([]);
        $this->expectExceptionMessage('Card ID is invalid!');
        $this->expectException(InvalidArgumentException::class);

        $this->atmService->calculate(1);
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
        $atm = m::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-01-01'));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(110, $result);
    }

    public function test_is_saturday()
    {
        $atm = m::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-04-24'));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(110, $result);
    }

    public function test_is_sunday()
    {
        $atm = m::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-04-25'));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(110, $result);
    }

    public function test_is_holiday_and_is_saturday()
    {
        $atm = m::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-05-01'));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(110, $result);
   }

    public function test_is_holiday_and_is_sunday()
    {
        $atm = m::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2017-04-30'));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(110, $result);
    }

    public function test_normal_day_at_8h44 ()
    {
        $atm = m::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-04-15 08:44:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(110, $result);
    }

    public function test_normal_day_at_8h45 ()
    {
        $atm = m::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-04-15 08:45:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(0, $result);
    }

    public function test_normal_day_at_8h46 ()
    {
        $atm = m::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-04-15 08:46:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(0, $result);
    }

    public function test_normal_day_at_17h58 ()
    {
        $atm = m::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-04-15 17:58:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(0, $result);
    }

    public function test_normal_day_at_17h59 ()
    {
        $atm = m::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-04-15 17:59:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(0, $result);
    }

    public function test_normal_day_at_18h00 ()
    {
        $atm = m::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-04-15 18:00:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(110, $result);
    }
}
