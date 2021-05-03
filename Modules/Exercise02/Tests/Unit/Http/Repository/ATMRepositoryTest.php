<?php

namespace Modules\Exercise03\Tests\Unit\Http\Requests;

use Modules\Exercise02\Repositories\ATMRepository;
use Modules\Exercise02\Models\ATM;
use Tests\TestCase;
use Mockery as m;

class ATMRepositoryTest extends TestCase
{
    protected $atmRepo;
    protected $model;

    public function setUp(): void
    {
        parent::setUp();

        $this->model = m::mock(ATM::class)->makePartial();
        $this->atmRepo = new ATMRepository($this->model);
    }

    public function test_find()
    {
        $this->model->shouldReceive('where->first')->andReturn([]);

        $result = $this->atmRepo->find(1);
        return $this->assertEquals([], $result);
    }
}
