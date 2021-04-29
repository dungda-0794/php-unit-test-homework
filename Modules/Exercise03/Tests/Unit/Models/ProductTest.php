<?php

namespace Modules\Exercise03\Tests\Unit\Models;

use Tests\ModelTestCase as TestCase;
use Mockery as m;
use Modules\Exercise03\Models\Product;
use Modules\Exercise03\Database\Factories\ProductFactory;

class ATMTest extends TestCase
{
    public function test_model_configuration()
    {
        $this->runConfigurationAssertions(new Product(), [
            'table' => 'exercise03_products',
            'fillable' => [
                'name',
                'type',
            ]
        ]);
    }

    public function test_new_factory()
    {
        $model = m::Mock(Product::class);

        $this->assertInstanceOf(ProductFactory::class, $model->newFactory());
    }
}
