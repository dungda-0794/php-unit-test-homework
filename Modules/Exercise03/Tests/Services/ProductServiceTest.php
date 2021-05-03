<?php

namespace Modules\Exercise03\Tests\Unit\Services;

use Modules\Exercise03\Repositories\ProductRepository;
use Modules\Exercise03\Services\ProductService;
use InvalidArgumentException;
use Mockery as m;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    protected $productService;
    protected $productRepo;

    public function setUp(): void
    {
        parent::setUp();

        $this->productRepo = m::mock(ProductRepository::class);
        $this->productService = new ProductService($this->productRepo);
    }

    public function test_without_any_products()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->productService->calculateDiscount([]);
    }

    public function test_less_than_7_products_have_both_white_shirt_and_caravat()
    {
        $products = [
            '1' => 2,
            '2' => 3,
        ];

        $result = $this->productService->calculateDiscount($products);
        return $this->assertEquals(5, $result);
    }

    public function test_less_than_7_products_have_caravat_and_other()
    {
        $products = [
            '1' => 3,
            '3' => 1,
        ];

        $result = $this->productService->calculateDiscount($products);
        return $this->assertEquals(0, $result);
    }

    public function test_less_than_7_products_have_white_shirt_and_other()
    {
        $products = [
            '2' => 3,
            '3' => 1,
        ];

        $result = $this->productService->calculateDiscount($products);
        return $this->assertEquals(0, $result);
    }

    public function test_greater_than_7_products()
    {
        $products = [
            '3' => 7,
        ];

        $result = $this->productService->calculateDiscount($products);
        return $this->assertEquals(7, $result);
    }

    public function test_greater_than_7_products_have_white_shirt_and_other()
    {
        $products = [
            '2' => 4,
            '3' => 4,
        ];

        $result = $this->productService->calculateDiscount($products);
        return $this->assertEquals(7, $result);
    }

    public function test_greater_than_7_products_have_caravat_and_other()
    {
        $products = [
            '1' => 4,
            '3' => 4,
        ];

        $result = $this->productService->calculateDiscount($products);
        return $this->assertEquals(7, $result);
    }

    public function test_greater_than_7_products_have_both_white_shirt_and_caravat()
    {
        $products = [
            '1' => 5,
            '2' => 3,
        ];

        $result = $this->productService->calculateDiscount($products);
        return $this->assertEquals(12, $result);
    }

    public function test_get_all_products()
    {
        $this->productRepo->shouldReceive('all')->andReturn([]);

        $result = $this->productService->getAllProducts();
        return $this->assertEquals([], $result);
    }
}
