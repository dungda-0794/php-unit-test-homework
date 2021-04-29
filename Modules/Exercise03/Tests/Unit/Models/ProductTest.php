<?php

namespace Modules\Exercise03\Tests\Unit\Models;

use Mockery;
use Modules\Exercise03\Database\Factories\ProductFactory;
use Modules\Exercise03\Models\Product;
use Tests\ModelTestCase as TestCase;

class ProductTest extends TestCase
{
    public function test_model_configuration()
    {
        $this->runConfigurationAssertions(new Product(), [
            'table' => 'exercise03_products',
            'fillable' => [
                'name',
                'type',
            ],
        ]);
    }

    public function test_new_factory()
    {
        $model = Mockery::Mock(Product::class);
        $this->assertInstanceOf(ProductFactory::class, $model->newFactory());
    }
}
