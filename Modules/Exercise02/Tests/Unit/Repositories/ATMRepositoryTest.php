<?php

namespace Modules\Exercise02\Tests\Unit\Http\Requests;

use Tests\TestCase;
use Modules\Exercise02\Repositories\ATMRepository;
use Mockery as m;
use Modules\Exercise02\Models\ATM;

class ATMRepositoryTest extends TestCase
{
    protected $atmRepository;
    protected $model;

    public function setUp(): void
    {
        parent::setUp();

        $this->model = m::mock(ATM::class)->makePartial();
        $this->atmRepository = new ATMRepository($this->model);
    }

    public function test_find()
    {
        $this->model->shouldReceive('where->first')->andreturn([]);

        $result = $this->atmRepository->find(1);
        $this->assertEquals([], $result);
    }
}
