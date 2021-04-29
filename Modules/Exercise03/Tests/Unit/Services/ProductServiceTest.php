<?php

namespace Modules\Exercise03\Tests\Unit\Services;

use Tests\TestCase;
use Modules\Exercise03\Services\ProductService;
use Modules\Exercise03\Repositories\ProductRepository;
use Modules\Exercise03\Models\Product;
use InvalidArgumentException;
use Mockery;

class ProductServiceTest extends TestCase
{
    protected $productService;
    protected $productRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->productRepository = Mockery::mock(ProductRepository::class);
        $this->productService = new ProductService($this->productRepository);
    }

    public function test_without_any_products()
    {
        $products = [
                '1' => -1,
                '2' => -3,
        ];
        $this->expectException(InvalidArgumentException::class);
        $this->productService->calculateDiscount($products);
    }

    public function test_less_than_7_products_including_both_shirt_and_caravat()
    {
        $products = [
                '1' => 2,
                '2' => 3,
        ];
        $result = $this->productService->calculateDiscount($products);
        $this->assertEquals(5, $result);
    }

    public function test_less_than_7_products_including_caravat_and_other()
    {
        $products = [
                '1' => 3,
                '3' => 1,
        ];
        $result = $this->productService->calculateDiscount($products);
        $this->assertEquals(0, $result);
    }

    public function test_less_than_7_products_including_shirt_and_other()
    {
        $products = [
                '2' => 3,
                '3' => 1,
        ];
        $result = $this->productService->calculateDiscount($products);
        $this->assertEquals(0, $result);
    }

    public function test_more_than_7_products_including_both_shirt_and_caravat()
    {
        $products = [
                '1' => 5,
                '2' => 3,
        ];
        $result = $this->productService->calculateDiscount($products);
        $this->assertEquals(12, $result);
    }

    public function test_more_than_7_products()
    {
        $products = [
                '3' => 7,
        ];
        $result = $this->productService->calculateDiscount($products);
        $this->assertEquals(7, $result);
    }

    public function test_more_than_7_products_including_shirt_and_other()
    {
        $products = [
                '2' => 4,
                '3' => 4,
        ];
        $result = $this->productService->calculateDiscount($products);
        $this->assertEquals(7, $result);
    }

    public function test_more_than_7_products_including_caravat_and_other()
    {
        $products = [
                '1' => 4,
                '3' => 4,
        ];
        $result = $this->productService->calculateDiscount($products);
        $this->assertEquals(7, $result);
    }

    public function test_get_all_products()
    {
        $this->productRepository->shouldReceive('all')->andreturn([]);

        $result = $this->productService->getAllProducts();
        $this->assertEquals([], $result);
    }
}
