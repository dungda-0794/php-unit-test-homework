<?php

namespace Modules\Exercise08\Tests\Unit\Http\Requests;

use Tests\TestCase;
use Modules\Exercise08\Http\Requests\CalculateRequest;

class CalculateRequestTest extends TestCase
{
    protected $calculateRequest;

    public function setUp(): void
    {
        parent::setUp();
        $this->calculateRequest = new CalculateRequest();
    }

    public function test_rules()
    {
        $rules = [
            'name' => 'required',
            'age' => 'required|integer',
            'gender' => 'required',
            'booking_date' => 'required|date',
        ];

        $this->assertEquals($rules, $this->calculateRequest->rules());
    }
}
