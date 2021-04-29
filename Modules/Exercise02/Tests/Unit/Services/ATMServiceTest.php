<?php

namespace Modules\Exercise02\Tests\Unit\Services;

use Modules\Exercise02\Repositories\ATMRepository;
use Modules\Exercise02\Services\ATMService;
use Modules\Exercise02\Models\ATM;
use InvalidArgumentException;
use Carbon\Carbon;
use Mockery as m;
use Tests\TestCase;

class ATMServiceTest extends TestCase
{
    protected $atmService;
    protected $atmRepo;

    public function setUp(): void
    {
        parent::setUp();

        $this->atmRepo = m::mock(ATMRepository::class);
        $this->atmService = new ATMService($this->atmRepo);
    }

    public function test_has_not_card()
    {
        $this->atmRepo->shouldReceive('find')->andReturn([]);

        $result = $this->atmService->calculate(1);

        $this->expectExceptionMessage('Card ID is invalid!');
        $this->expectException(InvalidArgumentException::class);

        return $this->assertInstanceOf(InvalidArgumentException::class, $result);
    }

    public function test_card_is_vip()
    {
        $atm = m::mock(ATM::class)->makePartial();
        $atm->is_vip = true;
        $this->atmRepo->shouldReceive('find')->andReturn($atm);

        $result = $this->atmService->calculate(1);
        return $this->assertEquals(0, $result);
    }

     public function test_day_is_holiday()
    {
        $atm = m::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-04-29'));
        $this->atmRepo->shouldReceive('find')->andReturn($atm);

        $result = $this->atmService->calculate(1);
        return $this->assertEquals(110, $result);
    }

    public function test_day_is_holiday_and_is_saturday()
    {
        $atm = m::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-05-01'));
        $this->atmRepo->shouldReceive('find')->andReturn($atm);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(110, $result);
   }

    public function test_day_is_holiday_and_is_sunday()
    {
        $atm = m::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-02-14'));
        $this->atmRepo->shouldReceive('find')->andReturn($atm);

        $result = $this->atmService->calculate(1);
        return $this->assertEquals(110, $result);
    }

    public function test_day_is_saturday()
    {
        $atm = m::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-04-2'));
        $this->atmRepo->shouldReceive('find')->andReturn($atm);

        $result = $this->atmService->calculate(1);
        return $this->assertEquals(110, $result);
    }

    public function test_day_is_sunday()
    {
        $atm = m::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-04-25'));
        $this->atmRepo->shouldReceive('find')->andReturn($atm);

        $result = $this->atmService->calculate(1);
        return $this->assertEquals(110, $result);
    }

        public function test_normal_day_at_8h44 ()
    {
        $atm = m::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-04-27 08:44:00'));
        $this->atmRepo->shouldReceive('find')->andReturn($atm);

        $result = $this->atmService->calculate(1);
        return $this->assertEquals(110, $result);
    }

    public function test_normal_day_at_8h45 ()
    {
        $atm = m::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-04-27 08:45:00'));
        $this->atmRepo->shouldReceive('find')->andReturn($atm);

        $result = $this->atmService->calculate(1);
        return $this->assertEquals(0, $result);
    }

    public function test_normal_day_at_8h46 ()
    {
        $atm = m::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-04-15 08:46:00'));
        $this->atmRepo->shouldReceive('find')->andReturn($atm);

        $result = $this->atmService->calculate(1);
        return $this->assertEquals(0, $result);
    }

    public function test_normal_day_at_17h58 ()
    {
        $atm = m::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-04-15 17:58:00'));
        $this->atmRepo->shouldReceive('find')->andReturn($atm);

        $result = $this->atmService->calculate(1);
        return $this->assertEquals(0, $result);
    }

    public function test_normal_day_at_17h59 ()
    {
        $atm = m::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-04-15 17:59:00'));
        $this->atmRepo->shouldReceive('find')->andReturn($atm);

        $result = $this->atmService->calculate(1);
        return $this->assertEquals(0, $result);
    }

    public function test_normal_day_at_18h00 ()
    {
        $atm = m::mock(ATM::class)->makePartial();
        Carbon::setTestNow(Carbon::parse('2021-04-15 18:00:00'));
        $this->atmRepo->shouldReceive('find')->andReturn($atm);

        $result = $this->atmService->calculate(1);
        return $this->assertEquals(110, $result);
    }
}
