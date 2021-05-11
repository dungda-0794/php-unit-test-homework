<?php

namespace Modules\Exercise03\Tests\Unit\Http\Controllers;

use Tests\TestCase;
use Modules\Exercise03\Http\Controllers\ProductController;
use Mockery as m;
use Modules\Exercise03\Services\ProductService;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ProductControllerTest extends TestCase
{
    protected $productService;
    protected $productController;

    public function setUp(): void
    {
        parent::setUp();

        $this->productService = m::mock(ProductService::class);
        $this->productController = new ProductController($this->productService);
    }

    public function test_index()
    {
        $this->productService->shouldReceive('getAllProducts')->andreturn([]);

        $result = $this->productController->index();
        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('exercise03::index', $result->getName());
    }

    public function test_checkout()
    {
        $request =  new CheckoutRequest();
        $request->total_products = 10;

        $this->productService->shouldReceive('calculateDiscount')->andreturn([]);

        $result = $this->productController->checkout($request);
        $this->assertInstanceOf(JsonResponse::class, $result);
    }
}
