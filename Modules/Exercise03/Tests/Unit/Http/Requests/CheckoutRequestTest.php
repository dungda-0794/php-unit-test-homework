<?php

namespace Modules\Exercise03\Tests\Unit\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use Modules\Exercise03\Http\Requests\CheckoutRequest;

class CheckoutRequestTest extends TestCase
{
    public function test_rules()
    {
        $request = new CheckoutRequest();

        $this->assertEquals([
            'total_products' => 'required|array',
            'total_products.*' => 'nullable|integer|min:0',
        ], $request->rules());
    }
}
