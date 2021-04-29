<?php

namespace Modules\Exercise08\Tests\Unit\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use Modules\Exercise08\Http\Requests\CalculateRequest;

class CalculateRequestTest extends TestCase
{
    public function test_rules()
    {
        $request = new CalculateRequest();

        $this->assertEquals([
            'name' => 'required',
            'age' => 'required|integer',
            'gender' => 'required',
            'booking_date' => 'required|date',
        ], $request->rules());
    }
}
