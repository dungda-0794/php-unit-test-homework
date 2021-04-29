<?php

namespace Modules\Exercise03\Tests\Unit\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Mockery as m;
use Modules\Exercise03\Http\Controllers\ProductController;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Modules\Exercise03\Services\ProductService;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    protected $productController;
    protected $productService;

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
        $request =  m::mock(CheckoutRequest::class);

        $request->shouldReceive('input')->andreturn([
            'total_products' => 1,
        ]);
        $this->productService->shouldReceive('calculateDiscount')->andreturn([]);

        $result = $this->productController->checkout($request);
        $this->assertInstanceOf(JsonResponse::class, $result);
    }
}
