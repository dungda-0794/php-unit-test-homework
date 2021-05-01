<?php

namespace Tests\Unit\Modules\Exercise08\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Mockery;
use Modules\Exercise08\Http\Controllers\TicketController;
use Modules\Exercise08\Http\Requests\CalculateRequest;
use Modules\Exercise08\Services\TicketService;
use Tests\TestCase;

class TicketControllerTest extends TestCase
{
    protected $ticketService;

    protected $ticketController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ticketService = Mockery::mock(TicketService::class)->makePartial();
        $this->ticketController = new TicketController($this->ticketService);
    }

    public function test_index()
    {
        $this->assertInstanceOf(View::class, $this->ticketController->index());
    }

    public function test_calculate_price_fail()
    {
        $requestMock =  Mockery::mock(CalculateRequest::class);

        $requestMock->shouldReceive('only')->andreturn([
            'age' => '',
            'booking_date' => '',
            'gender' => '',
            'name' => '',
        ]);
        $this->ticketService->shouldReceive('calculatePrice')->andreturn(0);

        $result = $this->ticketController->calculatePrice($requestMock);
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }

    public function test_calculate_price()
    {
        $requestMock =  Mockery::mock(CalculateRequest::class);
        $requestMock->shouldReceive('only')->andreturn([
            'age' => '',
            'booking_date' => '',
            'gender' => '',
            'name' => '',
        ]);

        $this->ticketService->shouldReceive('calculatePrice')->andreturn(1);
        Session::shouldReceive('flash')->andReturn(1);
        Session::shouldReceive('previousUrl')->andReturn();
        Session::shouldReceive('driver')->andReturn(new Store('test', new \SessionHandler()));

        $result = $this->ticketController->calculatePrice($requestMock);
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }
}
