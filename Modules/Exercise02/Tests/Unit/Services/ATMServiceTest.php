<?php

namespace Modules\Exercise02\Tests\Unit\Services;

use Mockery;
use Tests\TestCase;
use Modules\Exercise02\Services\ATMService;
use Modules\Exercise02\Repositories\ATMRepository;
use Modules\Exercise02\Models\ATM;
use InvalidArgumentException;
use Carbon\Carbon;

class ATMRepositoryTest extends TestCase
{
    protected $atmService;
    protected $atmRepository;
    protected $atmModel;

    public function setUp(): void
    {
        parent::setUp();

        $this->atmRepository = Mockery::mock(ATMRepository::class)->makePartial();
        $this->atmService = new ATMService($this->atmRepository);
        $this->atmModel = Mockery::mock(ATM::class)->makePartial();
    }

    // test customer vip and holiday
    public function test_customer_vip_holiday_and_saturday()
    {
        $this->atmModel->is_vip = true;
        Carbon::setTestNow(Carbon::parse('2021-05-01'));
        $this->atmRepository->shouldReceive('find')->andreturn($this->atmModel);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(0, $result);
    }

    public function test_customer_vip_holiday_and_sunday()
    {
        $this->atmModel->is_vip = true;
        Carbon::setTestNow(Carbon::parse('2021-05-02'));
        $this->atmRepository->shouldReceive('find')->andreturn($this->atmModel);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(0, $result);
    }

    public function test_customer_vip_holiday_and_start_0h00()
    {
        $this->atmModel->is_vip = true;
        Carbon::setTestNow(Carbon::parse('2021-01-01 00:44:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($this->atmModel);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(0, $result);
    }

    public function test_customer_vip_holiday_and_start_8h45()
    {
        $this->atmModel->is_vip = true;
        Carbon::setTestNow(Carbon::parse('2021-01-01 08:46:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($this->atmModel);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(0, $result);
    }

    public function test_customer_vip_holiday_and_start_18h00()
    {
        $this->atmModel->is_vip = true;
        Carbon::setTestNow(Carbon::parse('2021-01-01 18:44:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($this->atmModel);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(0, $result);
    }

    // test customer vip and not holiday
    public function test_customer_vip_and_saturday()
    {
        $this->atmModel->is_vip = true;
        Carbon::setTestNow(Carbon::parse('2021-04-03'));
        $this->atmRepository->shouldReceive('find')->andreturn($this->atmModel);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(0, $result);
    }

    public function test_customer_vip_and_sunday()
    {
        $this->atmModel->is_vip = true;
        Carbon::setTestNow(Carbon::parse('2021-04-04'));
        $this->atmRepository->shouldReceive('find')->andreturn($this->atmModel);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(0, $result);
    }

    public function test_customer_vip_start_0h00()
    {
        $this->atmModel->is_vip = true;
        Carbon::setTestNow(Carbon::parse('2021-01-06 00:44:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($this->atmModel);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(0, $result);
    }
    
    public function test_customer_vip_start_8h45()
    {
        $this->atmModel->is_vip = true;
        Carbon::setTestNow(Carbon::parse('2021-01-06 08:46:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($this->atmModel);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(0, $result);
    }

    public function test_customer_vip_start_18h00()
    {
        $this->atmModel->is_vip = true;
        Carbon::setTestNow(Carbon::parse('2021-01-06 18:44:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($this->atmModel);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(0, $result);
    }

    // test customer normal and holiday
    public function test_not_customer_vip_holiday_and_saturday()
    {
        Carbon::setTestNow(Carbon::parse('2021-05-01'));
        $this->atmRepository->shouldReceive('find')->andreturn($this->atmModel);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(110, $result);
    }

    public function test_not_customer_vip_holiday_and_sunday()
    {
        Carbon::setTestNow(Carbon::parse('2021-05-02'));
        $this->atmRepository->shouldReceive('find')->andreturn($this->atmModel);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(110, $result);
    }

    public function test_not_customer_vip_holiday_and_start_0h00()
    {
        Carbon::setTestNow(Carbon::parse('2021-01-01 00:44:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($this->atmModel);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(110, $result);
    }

    public function test_not_customer_vip_holiday_and_start_8h45()
    {
        Carbon::setTestNow(Carbon::parse('2021-01-01 08:46:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($this->atmModel);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(110, $result);
    }

    public function test_not_customer_vip_holiday_and_start_18h00()
    {
        Carbon::setTestNow(Carbon::parse('2021-01-01 18:44:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($this->atmModel);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(110, $result);
    }


    // test saturday and sunday
    public function test__saturday()
    {
        Carbon::setTestNow(Carbon::parse('2021-04-03'));
        $this->atmRepository->shouldReceive('find')->andreturn($this->atmModel);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(110, $result);
    }

    public function test__sunday()
    {
        Carbon::setTestNow(Carbon::parse('2021-04-04'));
        $this->atmRepository->shouldReceive('find')->andreturn($this->atmModel);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(110, $result);
    }


    // test normal day
    public function test_nomal_day_start_0h00()
    {
        Carbon::setTestNow(Carbon::parse('2021-04-06 00:44:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($this->atmModel);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(110, $result);
    }

    public function test_nomal_day_start_8h45()
    {
        Carbon::setTestNow(Carbon::parse('2021-04-06 08:46:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($this->atmModel);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(0, $result);
    }

    public function test_nomal_day_start_18h00()
    {
        Carbon::setTestNow(Carbon::parse('2021-04-06 18:44:00'));
        $this->atmRepository->shouldReceive('find')->andreturn($this->atmModel);

        $result = $this->atmService->calculate(1);
        $this->assertEquals(110, $result);
    }

    // test null card id
    public function test_without_card()
    {
        $this->atmRepository->shouldReceive('find')->andreturn([]);
        $this->expectExceptionMessage('Card ID is invalid!');
        $this->expectException(InvalidArgumentException::class);

        $this->atmService->calculate(1);
    }
}
