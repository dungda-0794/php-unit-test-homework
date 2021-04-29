<?php

namespace Modules\Exercise03\Tests\Unit\Http\Requests;

use Mockery as m;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Repositories\ProductRepository;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    protected $productRepository;
    protected $model;

    public function setUp(): void
    {
        parent::setUp();

        $this->model = m::mock(Product::class)->makePartial();
        $this->productRepository = new ProductRepository($this->model);
    }

    public function test_find()
    {
        $this->model->shouldReceive('all')->andreturn([]);

        $result = $this->productRepository->all(1);
        $this->assertEquals([], $result);
    }
}
