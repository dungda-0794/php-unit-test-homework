<?php

namespace Tests\Unit\Modules\Exercise03\Services;

use Illuminate\Support\Collection;
use Mockery;
use InvalidArgumentException;
use Modules\Exercise03\Models\Product;
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

    public function test_get_all_products()
    {
        $this->productRepository->shouldReceive('all')->andReturn(collect([]));

        $this->assertInstanceOf(Collection::class, $this->productService->getAllProducts());
    }

    public function test_not_valid_quantity()
    {
        $totalProducts = [
            Product::CRAVAT_TYPE => -1,
            Product::WHITE_SHIRT_TYPE => 0,
            Product::OTHER_TYPE => 0,
        ];
        $this->expectException(InvalidArgumentException::class);
        $this->productService->calculateDiscount($totalProducts);
    }

    public function test_calculate_discount_total_product_lower_than_7_no_white_shirt_no_tie()
    {
        $totalProducts = [
            Product::CRAVAT_TYPE => 0,
            Product::WHITE_SHIRT_TYPE => 0,
            Product::OTHER_TYPE => 0,
        ];

        $discount = $this->productService->calculateDiscount($totalProducts);

        $this->assertEquals(0, $discount);
    }

    public function test_calculate_discount_total_product_lower_than_7_no_white_shirt_but_have_tie()
    {
        $totalProducts = [
            Product::CRAVAT_TYPE => 1,
            Product::WHITE_SHIRT_TYPE => 0,
            Product::OTHER_TYPE => 0,
        ];

        $discount = $this->productService->calculateDiscount($totalProducts);

        $this->assertEquals(0, $discount);
    }

    public function test_calculate_discount_total_product_lower_than_7_have_white_shirt_no_tie()
    {
        $totalProducts = [
            Product::CRAVAT_TYPE => 0,
            Product::WHITE_SHIRT_TYPE => 1,
            Product::OTHER_TYPE => 0,
        ];

        $discount = $this->productService->calculateDiscount($totalProducts);

        $this->assertEquals(0, $discount);
    }

    public function test_calculate_discount_total_product_lower_than_7_have_white_shirt_and_tie()
    {
        $totalProducts = [
            Product::CRAVAT_TYPE => 1,
            Product::WHITE_SHIRT_TYPE => 1,
            Product::OTHER_TYPE => 0,
        ];

        $discount = $this->productService->calculateDiscount($totalProducts);

        $this->assertEquals(5, $discount);
    }

    public function test_calculate_discount_total_product_bigger_or_equal_7_no_white_shirt_no_tie()
    {
        $totalProducts = [
            Product::CRAVAT_TYPE => 0,
            Product::WHITE_SHIRT_TYPE => 0,
            Product::OTHER_TYPE => 7,
        ];

        $discount = $this->productService->calculateDiscount($totalProducts);

        $this->assertEquals(7, $discount);
    }

    public function test_calculate_discount_total_product_bigger_or_equal_7_no_white_shirt_but_have_tie()
    {
        $totalProducts = [
            Product::CRAVAT_TYPE => 0,
            Product::WHITE_SHIRT_TYPE => 1,
            Product::OTHER_TYPE => 7,
        ];

        $discount = $this->productService->calculateDiscount($totalProducts);

        $this->assertEquals(7, $discount);
    }

    public function test_calculate_discount_total_product_bigger_or_equal_7_have_white_shirt_no_tie()
    {
        $totalProducts = [
            Product::CRAVAT_TYPE => 1,
            Product::WHITE_SHIRT_TYPE => 0,
            Product::OTHER_TYPE => 7,
        ];

        $discount = $this->productService->calculateDiscount($totalProducts);

        $this->assertEquals(7, $discount);
    }

    public function test_calculate_discount_total_product_bigger_or_equal_7_have_white_shirt_and_tie()
    {
        $totalProducts = [
            Product::CRAVAT_TYPE => 1,
            Product::WHITE_SHIRT_TYPE => 1,
            Product::OTHER_TYPE => 7,
        ];

        $discount = $this->productService->calculateDiscount($totalProducts);

        $this->assertEquals(12, $discount);
    }
}
