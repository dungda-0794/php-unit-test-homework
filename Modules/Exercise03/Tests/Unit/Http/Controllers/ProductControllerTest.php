<?php

namespace Modules\Exercise03\Tests\Unit\Http\Controllers;

use Tests\TestCase;
use Mockery;
use Illuminate\View\View;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Modules\Exercise03\Services\ProductService;
use Modules\Exercise03\Http\Controllers\ProductController;
use Illuminate\Http\JsonResponse;

class ProductControllerTest extends TestCase
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
        $request =  Mockery::mock(CheckoutRequest::class);

        $request->shouldReceive('input')->andreturn([
            'total_products' => 2,
        ]);
        $this->productService->shouldReceive('calculateDiscount')->andreturn([]);

        $result = $this->productController->checkout($request);

        $this->assertInstanceOf(JsonResponse::class, $result);
    }
}
