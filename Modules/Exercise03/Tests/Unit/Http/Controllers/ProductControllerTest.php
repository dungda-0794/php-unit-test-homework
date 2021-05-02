<?php

namespace Tests\Unit\Modules\Exercise03\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Mockery;
use Modules\Exercise03\Http\Controllers\ProductController;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Modules\Exercise03\Services\ProductService;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    protected $productService;

    protected $productControllerTest;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productService = Mockery::mock(ProductService::class)->makePartial();
        $this->productControllerTest = new ProductController($this->productService);
    }

    public function test_index()
    {
        $this->productService->shouldReceive('getAllProducts')->andReturn([]);
        $this->assertInstanceOf(View::class, $this->productControllerTest->index());
    }

    public function test_checkout()
    {
        $checkoutRequestMock = Mockery::mock(CheckoutRequest::class);

        $checkoutRequestMock->shouldReceive('input')->andReturn([
            'total_products' => [
                1 => 1
            ],
        ]);
        $this->productService->shouldReceive('calculateDiscount')->andReturn(0);

        $response = $this->productControllerTest->checkout($checkoutRequestMock);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}
