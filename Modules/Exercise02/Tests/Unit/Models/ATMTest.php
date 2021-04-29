<?php

namespace Modules\Exercise02\Tests\Unit\Models;

use Tests\ModelTestCase as TestCase;
use Modules\Exercise02\Database\Factories\ATMFactory;
use Modules\Exercise02\Models\ATM;
use Mockery as m;

class ATMTest extends TestCase
{
    public function test_model_configuration()
    {
        $this->runConfigurationAssertions(new ATM(), [
            'fillable' => [
                'card_id',
                'is_vip',
            ],
            'casts' => [
                'is_vip' => 'boolean',
                'id' => 'int',
            ],
        ]);
    }

    public function test_new_factory()
    {
        $model = m::Mock(ATM::class);
        $result = $model->newFactory();

        $this->assertInstanceOf(ATMFactory::class, $result);
    }
}
