<?php

namespace Tests\Unit\Modules\Exercise02\Tests\Unit\Services;

use Modules\Exercise02\Models\ATM;
use Modules\Exercise02\Services\ATMService;
use PHPUnit\Framework\TestCase;
use Mockery;
use Modules\Exercise02\Repositories\ATMRepository;
use InvalidArgumentException;
use Carbon\Carbon;

class ATMServiceTest extends TestCase
{
    protected $atmRepository;
    protected $atmService;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->atmRepository = Mockery::mock(ATMRepository::class);
        $this->atmService = new ATMService($this->atmRepository);
    }

    public function test_no_card()
    {
        $this->atmRepository->shouldReceive('find')->andreturn([]);
        $this->expectExceptionMessage('Card ID is invalid!');
        $this->expectException(InvalidArgumentException::class);

        $this->atmService->calculate(1);
    }

    public function test_vip()
    {
        $vip = Mockery::mock(ATM::class)->makePartial();
        $vip->id = 1;
        $vip->is_vip = true;
        $this->atmRepository->shouldReceive('find')
            ->andReturn($vip);
        $response = $this->atmService->calculate($vip->id);

        $this->assertEquals(ATMService::NO_FEE, $response);
    }

    public function test_holiday()
    {
        $atm = Mockery::mock(ATM::class)->makePartial();
        $atm->id = 1;
        Carbon::setTestNow(Carbon::parse('2021-01-01'));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $response = $this->atmService->calculate($atm->id);
        $this->assertEquals(ATMService::NORMAL_FEE, $response);
    }

    public function test_saturday()
    {
        $atm = Mockery::mock(ATM::class)->makePartial();
        $atm->id = 1;
        Carbon::setTestNow(Carbon::parse('2021-04-24'));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $response = $this->atmService->calculate($atm->id);
        $this->assertEquals(ATMService::NORMAL_FEE, $response);
    }

    public function test_sunday()
    {
        $atm = Mockery::mock(ATM::class)->makePartial();
        $atm->id = 1;
        Carbon::setTestNow(Carbon::parse('2021-04-25'));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $response = $this->atmService->calculate($atm->id);
        $this->assertEquals(ATMService::NORMAL_FEE, $response);
    }

    public function test_is_holiday_and_is_saturday()
    {
        $atm = Mockery::mock(ATM::class)->makePartial();
        $atm->id = 1;
        Carbon::setTestNow(Carbon::parse('2021-05-01'));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $response = $this->atmService->calculate($atm->id);
        $this->assertEquals(ATMService::NORMAL_FEE, $response);
    }

    public function test_is_holiday_and_is_sunday()
    {
        $atm = Mockery::mock(ATM::class)->makePartial();
        $atm->id = 1;
        Carbon::setTestNow(Carbon::parse('2017-04-30'));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $response = $this->atmService->calculate($atm->id);
        $this->assertEquals(ATMService::NORMAL_FEE, $response);
    }

    public function test_normal_day_at_8h44 ()
    {
        $atm = Mockery::mock(ATM::class)->makePartial();
        $atm->id = 1;
        Carbon::setTestNow(Carbon::parse('2021-04-15 08:44:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $response = $this->atmService->calculate($atm->id);
        $this->assertEquals(ATMService::NORMAL_FEE, $response);
    }

    public function test_normal_day_at_8h45 ()
    {
        $atm = Mockery::mock(ATM::class)->makePartial();
        $atm->id = 1;
        Carbon::setTestNow(Carbon::parse('2021-04-15 08:45:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $response = $this->atmService->calculate($atm->id);
        $this->assertEquals(ATMService::NO_FEE, $response);
    }

    public function test_normal_day_at_8h46 ()
    {
        $atm = Mockery::mock(ATM::class)->makePartial();
        $atm->id = 1;
        Carbon::setTestNow(Carbon::parse('2021-04-15 08:46:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $response = $this->atmService->calculate($atm->id);
        $this->assertEquals(ATMService::NO_FEE, $response);
    }

    public function test_normal_day_at_17h58 ()
    {
        $atm = Mockery::mock(ATM::class)->makePartial();
        $atm->id = 1;
        Carbon::setTestNow(Carbon::parse('2021-04-15 17:58:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $response = $this->atmService->calculate($atm->id);
        $this->assertEquals(ATMService::NO_FEE, $response);
    }

    public function test_normal_day_at_17h59 ()
    {
        $atm = Mockery::mock(ATM::class)->makePartial();
        $atm->id = 1;
        Carbon::setTestNow(Carbon::parse('2021-04-15 17:59:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $response = $this->atmService->calculate($atm->id);
        $this->assertEquals(ATMService::NO_FEE, $response);;
    }

    public function test_normal_day_at_18h00 ()
    {
        $atm = Mockery::mock(ATM::class)->makePartial();
        $atm->id = 1;
        Carbon::setTestNow(Carbon::parse('2021-04-15 18:00:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($atm);

        $response = $this->atmService->calculate($atm->id);
        $this->assertEquals(ATMService::NORMAL_FEE, $response);
    }
}
