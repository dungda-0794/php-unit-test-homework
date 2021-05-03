<?php

namespace Modules\Exercise03\Tests\Unit\Http\Requests;

use Modules\Exercise03\Repositories\ProductRepository;
use Modules\Exercise03\Models\Product;
use Mockery as m;

use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    protected $productRepo;
    protected $model;

    public function setUp(): void
    {
        parent::setUp();

        $this->model = m::mock(Product::class)->makePartial();
        $this->productRepo = new ProductRepository($this->model);
    }

    public function test_find()
    {
        $this->model->shouldReceive('all')->andreturn([]);

        $result = $this->productRepo->all(1);
        $this->assertEquals([], $result);
    }
}
