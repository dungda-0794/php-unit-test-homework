<?php

namespace Tests\Unit\Modules\Exercise08\Http\Controllers;

use Illuminate\Session\Store;
use SessionHandler;
use Illuminate\Support\Facades\Session;
use InvalidArgumentException;
use Illuminate\Http\RedirectResponse;
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
        $request = new CalculateRequest([
            'age' => -1,
            'booking_date' => '2021-04-26',
            'gender' => 'male',
            'name' => 'linh',
        ]);

        $this->ticketService->shouldReceive('calculatePrice')->andReturn(new InvalidArgumentException());
        $this->assertInstanceOf(RedirectResponse::class, $this->ticketController->calculatePrice($request));
    }

    public function test_calculate_price_success()
    {
        $request = new CalculateRequest([
            'age' => 13,
            'booking_date' => '2021-04-26',
            'gender' => 'male',
            'name' => 'linh',
        ]);

        $this->ticketService->shouldReceive('calculatePrice')->andReturn(1800);
        Session::shouldReceive('flash')->andReturn(true);
        Session::shouldReceive('driver')->andReturn(new Store('test', new SessionHandler()));
        Session::shouldReceive('previousUrl')->andReturn('/test');

        $this->assertInstanceOf(RedirectResponse::class, $this->ticketController->calculatePrice($request));
    }
}
