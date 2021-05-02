<?php

namespace Tests\Unit\Modules\Exercise02\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Mockery;
use Modules\Exercise02\Http\Controllers\Exercise02Controller;
use Modules\Exercise02\Http\Requests\ATMRequest;
use Modules\Exercise02\Services\ATMService;
use Tests\TestCase;

class Ex02ControllerTest extends TestCase
{
    protected $atmService;

    protected $ex02ControllerTest;

    protected function setUp(): void
    {
        parent::setUp();
        $this->atmService = Mockery::mock(ATMService::class)->makePartial();
        $this->ex02ControllerTest = new Exercise02Controller($this->atmService);
    }

    public function test_index()
    {
        $this->assertInstanceOf(View::class, $this->ex02ControllerTest->index());
    }

    public function test_take_atm_fee()
    {
        $atmRequestMock = Mockery::mock(ATMRequest::class)->makePartial();

        $atmRequestMock->shouldReceive('validated')->andReturn(new ATMRequest([
            'card_id' => 1,
        ]));
        $this->atmService->shouldReceive('calculate')->andReturn(0);

        $response = $this->ex02ControllerTest->takeATMFee($atmRequestMock);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }
}
