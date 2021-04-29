<?php

namespace Modules\Exercise02\Tests\Unit\Http\Controllers;

use Tests\TestCase;
use Mockery;
use Modules\Exercise02\Services\ATMService;
use Modules\Exercise02\Http\Requests\ATMRequest;
use Modules\Exercise02\Http\Controllers\Exercise02Controller;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class Exercise02ControllerTest extends TestCase
{
    protected $exercise02Controller;
    protected $atmService;
    protected $atmRequest;

    public function setUp(): void
    {
        parent::setUp();
        $this->atmService = Mockery::mock(ATMService::class);
        $this->atmRequest =  Mockery::mock(ATMRequest::class);
        $this->exercise02Controller = new Exercise02Controller($this->atmService);
    }

    public function test_index()
    {
        $this->assertInstanceOf(View::class, $this->exercise02Controller->index());
    }

    public function test_take_atm_fee()
    {
        $this->atmRequest->shouldReceive('validated')
            ->andreturn([
                'card_id' => 1,
            ]);
        $this->atmService->shouldReceive('calculate')
            ->andreturn(0);

        $result = $this->exercise02Controller->takeATMFee($this->atmRequest);
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }
}
