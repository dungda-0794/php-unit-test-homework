<?php

namespace Modules\Exercise08\Tests\Unit\Http\Requests;

use Modules\Exercise08\Http\Requests\CalculateRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class CalculateRequestTest extends TestCase
{
    protected $calculateRequest;

    public function setUp(): void
    {
        parent::setUp();
        $this->calculateRequest = new CalculateRequest();
    }

    public function test_validate_fails()
    {
        $validator = Validator::make([], $this->calculateRequest->rules());
        return $this->assertTrue($validator->fails());
    }

    public function test_rules()
    {
        $rules = [
            'name' => 'required',
            'age' => 'required|integer',
            'gender' => 'required',
            'booking_date' => 'required|date',
        ];

        return $this->assertEquals($rules, $this->calculateRequest->rules());
    }
}
