<?php

namespace Modules\Exercise02\Tests\Unit\Http\Requests;

use Tests\TestCase;
use Modules\Exercise02\Repositories\ATMRepository;
use Mockery as m;
use Modules\Exercise02\Models\ATM;

class ATMRepositoryTest extends TestCase
{
    protected $atmRepository;
    protected $atmmodel;

    public function setUp(): void
    {
        parent::setUp();

        $this->atmmodel = m::mock(ATM::class)->makePartial();
        $this->atmRepository = new ATMRepository($this->atmmodel);
    }

    public function test_find()
    {
        $this->atmmodel->shouldReceive('where->first')->andreturn([]);

        $result = $this->atmRepository->find(1);
        $this->assertEquals([], $result);
    }
}
