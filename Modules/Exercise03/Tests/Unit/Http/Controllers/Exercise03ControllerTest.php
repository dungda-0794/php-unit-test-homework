<?php

namespace Modules\Exercise03\Tests\Unit\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Mockery;
use Modules\Exercise03\Http\Controllers\ProductController;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Modules\Exercise03\Services\ProductService;
use Tests\TestCase;

class Exercise03ControllerTest extends TestCase
{
    protected $productController;
    protected $productService;

    public function setUp(): void
    {
        parent::setUp();

        $this->productService = Mockery::mock(ProductService::class);
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
        $request->total_products = 2;

        $this->productService->shouldReceive('calculateDiscount')->andreturn(1);

        $result = $this->productController->checkout($request);
        $this->assertInstanceOf(JsonResponse::class, $result);
    }
}
