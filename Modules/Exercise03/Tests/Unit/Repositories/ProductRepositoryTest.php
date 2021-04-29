<?php

namespace Modules\Exercise03\Tests\Unit\Http\Requests;

use Tests\TestCase;
use Modules\Exercise03\Repositories\ProductRepository;
use Modules\Exercise03\Models\Product;
use Mockery;

class ProductRepositoryTest extends TestCase
{
    protected $productRepository;
    protected $model;

    public function setUp(): void
    {
        parent::setUp();

        $this->model = Mockery::mock(Product::class)->makePartial();
        $this->productRepository = new ProductRepository($this->model);
    }

    public function test_find()
    {
        $this->model->shouldReceive('all')->andreturn([]);

        $result = $this->productRepository->all(1);
        $this->assertEquals([], $result);
    }
}
