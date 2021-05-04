<?php

namespace Modules\Exercise03\Tests\Unit\Models;

use Tests\ModelTestCase as TestCase;
use Modules\Exercise03\Database\Factories\ProductFactory;
use Modules\Exercise03\Models\Product;
use Mockery as m;

class ProductTest extends TestCase
{
    public function test_model_configuration()
    {
        $this->runConfigurationAssertions(new Product(), [
            'table' => 'exercise03_products',
            'fillable' => ['name', 'type',]
        ]);
    }

    public function test_new_factory()
    {
        $model = m::Mock(Product::class);
        $result = $model->newFactory();

        $this->assertInstanceOf(ProductFactory::class, $result);
    }
}
