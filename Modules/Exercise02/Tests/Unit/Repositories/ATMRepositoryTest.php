<?php

namespace Modules\Exercise02\Tests\Unit\Http\Requests;

use Tests\TestCase;
use Modules\Exercise02\Repositories\ATMRepository;
use Mockery;
use Modules\Exercise02\Models\ATM;

class ATMRepositoryTest extends TestCase
{
    protected $atmRepository;
    protected $atmModel;

    public function setUp(): void
    {
        parent::setUp();

        $this->atmModel = Mockery::mock(ATM::class)->makePartial();
        $this->atmRepository = new ATMRepository($this->atmModel);
    }

    public function test_find_function()
    {
        $this->atmModel->shouldReceive('where->first')->andreturn([]);

        $result = $this->atmRepository->find(1);
        $this->assertEquals([], $result);
    }
}
