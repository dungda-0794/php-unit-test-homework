<?php

namespace Tests\Unit\Modules\Exercise02\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Mockery;
use Modules\Exercise08\Http\Controllers\TicketController;
use Modules\Exercise08\Http\Requests\CalculateRequest;
use Modules\Exercise08\Services\TicketService;
use Tests\TestCase;

class Exercise08ControllerTest extends TestCase
{
    protected $ticketService;
    protected $exercise08Controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ticketService = Mockery::mock(TicketService::class)->makePartial();
        $this->exercise08Controller = new TicketController($this->ticketService);
    }

    public function test_index()
    {
        $result = $this->exercise08Controller->index();

        $this->assertInstanceOf(View::class, $result);
    }

    public function test_calculate_price_function_success()
    {
        $calculateRequest = new CalculateRequest();

        $this->ticketService->shouldReceive('calculatePrice')->andReturn(1);

        $result = $this->exercise08Controller->calculatePrice($calculateRequest);

        $this->assertInstanceOf(RedirectResponse::class, $result);
    }

    public function test_calculate_price_function_fail()
    {
        $calculateRequest = new CalculateRequest();

        $this->ticketService->shouldReceive('calculatePrice')->andReturn(null);

        $result = $this->exercise08Controller->calculatePrice($calculateRequest);

        $this->assertInstanceOf(RedirectResponse::class, $result);
    }
}
