<?php

namespace Modules\Exercise02\Tests\Unit\Models;

use Mockery;
use Modules\Exercise02\Database\Factories\ATMFactory;
use Modules\Exercise02\Models\ATM;
use Tests\ModelTest as TestCase;

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
        $model = Mockery::Mock(ATM::class);
        $this->assertInstanceOf(ATMFactory::class, $model->newFactory());
    }
}
