<?php

namespace Tests\Unit\Modules\Exercise03\Services;

use InvalidArgumentException;
use Mockery;
use Modules\Exercise03\Repositories\ProductRepository;
use Modules\Exercise03\Services\ProductService;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    protected $productRepository;

    protected $productService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productRepository = Mockery::mock(ProductRepository::class)->makePartial();
        $this->productService = new ProductService($this->productRepository);
    }

    public function test_get_all() {
        $this->productRepository->shouldReceive('all')->andReturn(collect([]));
        $expectResult = collect([]);

        $result = $this->productService->getAllProducts();
        $this->assertEquals($expectResult, $result);
    }

    public function test_no_cravat_in_cart() {
        $totalProducts = [
            '1' => -1,
            '2' => 1,
            '3' => 1
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->productService->calculateDiscount($totalProducts);
    }

    public function test_no_shirt_in_cart() {
        $totalProducts = [
            '1' => 1,
            '2' => -1,
            '3' => 1
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->productService->calculateDiscount($totalProducts);
    }

    public function test_no_items_in_cart() {
        $totalProducts = [
            '3' => -1
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->productService->calculateDiscount($totalProducts);
    }

    public function test_cravat_and_shirt_in_cart() {
        $totalProducts = [
            '1' => 1,
            '2' => 1,
        ];
        $result = $this->productService->calculateDiscount($totalProducts);

        $this->assertEquals(5, $result);
    }

    public function test_total_item_include_cravat_and_shirt_in_cart_equal_7() {
        $totalProducts = [
            '1' => 1,
            '2' => 1,
            '3' => 5
        ];
        $result = $this->productService->calculateDiscount($totalProducts);

        $this->assertEquals(12, $result);
    }

    public function test_total_item_include_cravat_and_shirt_in_cart_greater_7() {
        $totalProducts = [
            '1' => 2,
            '2' => 2,
            '3' => 5
        ];
        $result = $this->productService->calculateDiscount($totalProducts);

        $this->assertEquals(12, $result);
    }

    public function test_total_item_lower_7_and_no_shirt_no_cravat() {
        $totalProducts = [
            '3' => 1
        ];
        $result = $this->productService->calculateDiscount($totalProducts);

        $this->assertEquals(0, $result);
    }
}
