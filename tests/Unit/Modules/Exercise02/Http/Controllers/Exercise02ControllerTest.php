<?php

namespace Tests\Unit\Modules\Exercise02\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Mockery;
use Modules\Exercise02\Http\Controllers\Exercise02Controller;
use Modules\Exercise02\Http\Requests\ATMRequest;
use Modules\Exercise02\Services\ATMService;
use Tests\TestCase;

class Exercise02ControllerTest extends TestCase
{
    protected $atmService;
    protected $exercise02Controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->atmService = Mockery::mock(ATMService::class)->makePartial();
        $this->exercise02Controller = new Exercise02Controller($this->atmService);
    }

    public function test_index()
    {
        $this->assertInstanceOf(View::class, $this->exercise02Controller->index());
    }

    public function test_take_atm_fee()
    {
        $atmRequest = Mockery::mock(ATMRequest::class)->makePartial();

        $atmRequest->shouldReceive('validated')->andReturn(new ATMRequest([
            'card_id' => 10001,
        ]));
        $this->atmService->shouldReceive('calculate')->andReturn(0);

        $response = $this->exercise02Controller->takeATMFee($atmRequest);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }
}
