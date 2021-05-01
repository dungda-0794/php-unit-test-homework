<?php

namespace Modules\Exercise03\Tests\Unit\Http\Requests;

use Tests\TestCase;
use Modules\Exercise03\Repositories\ProductRepository;
use Mockery;
use Modules\Exercise03\Models\Product;

class ProductRepositoryTest extends TestCase
{
    protected $productRepository;
    protected $productModel;

    public function setUp(): void
    {
        parent::setUp();

        $this->productModel = Mockery::mock(Product::class)->makePartial();
        $this->productRepository = new ProductRepository($this->productModel);
    }

    public function test_find()
    {
        $this->productModel->shouldReceive('all')->andreturn([]);

        $result = $this->productRepository->all(4);
        $this->assertEquals([], $result);
    }
}
