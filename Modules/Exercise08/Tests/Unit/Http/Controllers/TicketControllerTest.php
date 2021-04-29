<?php

namespace Modules\Exercise08\Tests\Unit\Http\Controllers;

use Tests\TestCase;
use Mockery as m;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use SessionHandler;
use Modules\Exercise08\Services\TicketService;
use Modules\Exercise08\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Session;
use Illuminate\Session\Store;
use Modules\Exercise08\Http\Requests\CalculateRequest;

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

        $request->shouldReceive('only')->andreturn([
            'age' => '',
            'booking_date' => '',
            'gender' => '',
            'name' => '',
        ]);
        $this->ticketService->shouldReceive('calculatePrice')->andreturn(0);

        $result = $this->ticketController->calculatePrice($request);

        $this->assertInstanceOf(RedirectResponse::class, $result);
    }

    public function test_calculate_price()
    {
        $request =  m::mock(CalculateRequest::class);
        $request->shouldReceive('only')->andreturn([
            'age' => '',
            'booking_date' => '',
            'gender' => '',
            'name' => '',
        ]);

        $this->ticketService->shouldReceive('calculatePrice')->andreturn(1);
        Session::shouldReceive('flash')->andReturn(1);
        Session::shouldReceive('previousUrl')->andReturn();
        Session::shouldReceive('driver')->andReturn(new Store('test', new SessionHandler));

        $result = $this->ticketController->calculatePrice($request);

        $this->assertInstanceOf(RedirectResponse::class, $result);
    }
}
