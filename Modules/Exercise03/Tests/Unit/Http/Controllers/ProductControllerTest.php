<?php

namespace Modules\Exercise03\Tests\Unit\Http\Controllers;

use Mockery;
use Tests\TestCase;
use Modules\Exercise03\Http\Controllers\ProductController;
use Modules\Exercise03\Services\ProductService;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class ProductControllerTest extends TestCase
{
    protected $productController;
    protected $productService;
    protected $productRequest;

    public function setUp(): void
    {
        parent::setUp();

        $this->productService = Mockery::mock(ProductService::class);
        $this->productController = new ProductController($this->productService);
        $this->productRequest =  Mockery::mock(CheckoutRequest::class);
    }

    public function test_index()
    {
        $this->productService->shouldReceive('getAllProducts')
            ->andreturn([]);

        $result = $this->productController->index();
        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('exercise03::index', $result->getName());
    }

    public function test_checkout()
    {
        $this->productRequest->shouldReceive('input')
            ->andreturn([
                'total_products' => 1,
            ]);
        $this->productService->shouldReceive('calculateDiscount')
            ->andreturn([]);

        $result = $this->productController->checkout($this->productRequest);
        $this->assertInstanceOf(JsonResponse::class, $result);
    }
}
