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
    protected $ATMRepository;

    protected $ATMService;

    protected $atm;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ATMRepository = Mockery::mock(ATMRepository::class)->makePartial();
        $this->ATMService = new ATMService($this->ATMRepository);
    }

    public function test_no_card() {
        $this->ATMRepository->shouldReceive('find')->andReturn(null);
        $this->expectException(InvalidArgumentException::class);

        $this->ATMService->calculate(1);
    }

    public function test_card_is_vip() {
        $atm = Mockery::mock(ATM::class)->makePartial();
        $atm->card_id = 1;
        $atm->is_vip = true;
        $this->ATMRepository->shouldReceive('find')->andReturn($atm);

        $result = $this->ATMService->calculate($atm->card_id);

        $this->assertEquals(0, $result);
    }

    public function test_card_no_vip_and_holiday_time() {
        $atm = Mockery::mock(ATM::class)->makePartial();
        $atm->card_id = 1;
        $atm->is_vip = false;
        $this->ATMRepository->shouldReceive('find')->andReturn($atm);
        Carbon::setTestNow(Carbon::parse('2021-01-01'));

        $result = $this->ATMService->calculate($atm->card_id);

        $this->assertEquals(110, $result);
    }

    public function test_card_no_vip_and_weekend_time() {
        $atm = Mockery::mock(ATM::class)->makePartial();
        $atm->card_id = 1;
        $atm->is_vip = false;
        $this->ATMRepository->shouldReceive('find')->andReturn($atm);
        Carbon::setTestNow(Carbon::parse('2021-05-09'));

        $result = $this->ATMService->calculate($atm->card_id);

        $this->assertEquals(110, $result);
    }

    public function test_card_no_vip_and_working_time() {
        $atm = Mockery::mock(ATM::class)->makePartial();
        $atm->card_id = 1;
        $atm->is_vip = false;
        $this->ATMRepository->shouldReceive('find')->andReturn($atm);
        Carbon::setTestNow(Carbon::parse('2021-05-03 09:00:00'));

        $result = $this->ATMService->calculate($atm->card_id);

        $this->assertEquals(0, $result);
    }

    public function test_card_no_vip_and_out_of_working_time() {
        $atm = Mockery::mock(ATM::class)->makePartial();
        $atm->card_id = 1;
        $atm->is_vip = false;
        $this->ATMRepository->shouldReceive('find')->andReturn($atm);
        Carbon::setTestNow(Carbon::parse('2021-05-03 23:00:00'));

        $result = $this->ATMService->calculate($atm->card_id);

        $this->assertEquals(110, $result);
    }

    public function test_card_no_vip_and_out_of_working_time_844() {
        $atm = Mockery::mock(ATM::class)->makePartial();
        $atm->card_id = 1;
        $atm->is_vip = false;
        $this->ATMRepository->shouldReceive('find')->andReturn($atm);
        Carbon::setTestNow(Carbon::parse('2021-05-03 08:44:00'));

        $result = $this->ATMService->calculate($atm->card_id);

        $this->assertEquals(110, $result);
    }

    public function test_card_no_vip_and_out_of_working_time_1800() {
        $atm = Mockery::mock(ATM::class)->makePartial();
        $atm->card_id = 1;
        $atm->is_vip = false;
        $this->ATMRepository->shouldReceive('find')->andReturn($atm);
        Carbon::setTestNow(Carbon::parse('2021-05-03 18:00:00'));

        $result = $this->ATMService->calculate($atm->card_id);

        $this->assertEquals(110, $result);
    }

    public function test_card_no_vip_and_working_time_845() {
        $atm = Mockery::mock(ATM::class)->makePartial();
        $atm->card_id = 1;
        $atm->is_vip = false;
        $this->ATMRepository->shouldReceive('find')->andReturn($atm);
        Carbon::setTestNow(Carbon::parse('2021-05-03 08:45:00'));

        $result = $this->ATMService->calculate($atm->card_id);

        $this->assertEquals(0, $result);
    }

    public function test_card_no_vip_and_working_time_1759() {
        $atm = Mockery::mock(ATM::class)->makePartial();
        $atm->card_id = 1;
        $atm->is_vip = false;
        $this->ATMRepository->shouldReceive('find')->andReturn($atm);
        Carbon::setTestNow(Carbon::parse('2021-05-03 17:59:00'));

        $result = $this->ATMService->calculate($atm->card_id);

        $this->assertEquals(0, $result);
    }
}
