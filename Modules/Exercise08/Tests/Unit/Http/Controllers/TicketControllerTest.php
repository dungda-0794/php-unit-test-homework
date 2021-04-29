<?php

namespace Modules\Exercise08\Tests\Unit\Http\Controllers;

use Tests\TestCase;
use Modules\Exercise08\Http\Controllers\TicketController;
use Modules\Exercise08\Services\TicketService;
use Modules\Exercise08\Http\Requests\CalculateRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use SessionHandler;
use Illuminate\Session\Store;
use Mockery;

class TicketControllerTest extends TestCase
{
    protected $ticketController;
    protected $ticketService;

    public function setUp(): void
    {
        parent::setUp();

        $this->ticketService = Mockery::mock(TicketService::class);
        $this->ticketController = new TicketController($this->ticketService);
        $this->ticketRequest =  Mockery::mock(CalculateRequest::class);
    }

    public function test_index()
    {
        $result = $this->ticketController->index();
        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('exercise08::index', $result->getName());
    }

    public function test_calculate_price_fail()
    {
        $this->ticketRequest->shouldReceive('only')
            ->andreturn([
                'age' => '',
                'booking_date' => '',
                'gender' => '',
                'name' => '',
            ]);
        $this->ticketService->shouldReceive('calculatePrice')
            ->andreturn(0);

        $result = $this->ticketController->calculatePrice($this->ticketRequest);
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }

    public function test_calculate_price()
    {
        $this->ticketRequest->shouldReceive('only')
            ->andreturn([
                'age' => '',
                'booking_date' => '',
                'gender' => '',
                'name' => '',
            ]);

        $this->ticketService->shouldReceive('calculatePrice')
            ->andreturn(1);
        Session::shouldReceive('flash')
            ->andReturn(1);
        Session::shouldReceive('previousUrl')
            ->andReturn();
        Session::shouldReceive('driver')
            ->andReturn(new Store('test', new SessionHandler));

        $result = $this->ticketController->calculatePrice($this->ticketRequest);
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }
}
