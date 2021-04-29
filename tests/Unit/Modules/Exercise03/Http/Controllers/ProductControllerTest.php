<?php

namespace Tests\Unit\Modules\Exercise03\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\View\View;
use Mockery;
use Modules\Exercise03\Http\Controllers\ProductController;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Modules\Exercise03\Services\ProductService;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    protected $productService;
    protected $productController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productService = Mockery::mock(ProductService::class)->makePartial();
        $this->productController = new ProductController($this->productService);
    }

    public function test_index()
    {
        $this->productService->shouldReceive('getAllProducts')->andReturn([]);

        $response = $this->productController->index();

        $this->assertInstanceOf(View::class, $response);
    }

    public function test_checkout()
    {
        $request = new CheckoutRequest([
            'total_products' => [],
        ]);

        $this->productService->shouldReceive('calculateDiscount')->andReturn(0);

        $response = $this->productController->checkout($request);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}
