<?php

namespace Modules\Exercise08\Tests\Unit\Http\Controllers;

use Modules\Exercise08\Http\Controllers\TicketController;
use Modules\Exercise08\Http\Requests\CalculateRequest;
use Modules\Exercise08\Services\TicketService;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Session\Store;
use Illuminate\View\View;
use Mockery as m;
use SessionHandler;
use Tests\TestCase;

class TicketControllerTest extends TestCase
{
    protected $ticketController;
    protected $ticketService;

    public function setUp(): void
    {
        parent::setUp();

        $this->ticketService = m::mock(TicketService::class);
        $this->ticketController = new TicketController($this->ticketService);
    }

    public function test_index()
    {
        $result = $this->ticketController->index();
        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('exercise08::index', $result->getName());
    }

    public function test_calculate_price_fail()
    {
        $request =  m::mock(CalculateRequest::class);

        $request->shouldReceive('only')->andReturn([
            'age' => '',
            'booking_date' => '',
            'gender' => '',
            'name' => '',
        ]);
        $this->ticketService->shouldReceive('calculatePrice')->andReturn(0);

        $result = $this->ticketController->calculatePrice($request);
        return $this->assertInstanceOf(RedirectResponse::class, $result);
    }

    public function test_calculate_price()
    {
        $request =  m::mock(CalculateRequest::class);
        $request->shouldReceive('only')->andReturn([
            'age' => '',
            'booking_date' => '',
            'gender' => '',
            'name' => '',
        ]);

        $this->ticketService->shouldReceive('calculatePrice')->andReturn(1);

        $result = $this->ticketController->calculatePrice($request);
        return $this->assertInstanceOf(RedirectResponse::class, $result);
    }
}
