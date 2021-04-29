<?php

namespace Modules\Exercise02\Tests\Unit\Http\Controllers;

use Modules\Exercise02\Http\Controllers\Exercise02Controller;
use Modules\Exercise02\Http\Requests\ATMRequest;
use Modules\Exercise02\Services\ATMService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Mockery as m;
use Tests\TestCase;

class Exercise02ControllerTest extends TestCase
{
    protected $exercise02Controller;
    protected $atmService;

    public function setUp(): void
    {
        parent::setUp();
        $this->atmService = m::mock(ATMService::class);

        $this->exercise02Controller = new Exercise02Controller($this->atmService);
    }

    public function test_index()
    {
        $result = $this->exercise02Controller->index();
        $this->assertInstanceOf(View::class, $result);
    }

    public function test_take_atm_fee()
    {
        $request =  m::mock(ATMRequest::class);

        $request->shouldReceive('validated')->andreturn([
            'card_id' => 2,
        ]);
        $this->atmService->shouldReceive('calculate')->andReturn(0);

        $result = $this->exercise02Controller->takeATMFee($request);
        return $this->assertInstanceOf(RedirectResponse::class, $result);
    }
}
