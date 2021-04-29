<?php

namespace Modules\Exercise03\Tests\Unit\Http\Requests;

use Tests\TestCase;
use Modules\Exercise03\Http\Requests\CheckoutRequest;

class CheckoutRequestTest extends TestCase
{
    protected $checkoutRequest;

    public function setUp(): void
    {
        parent::setUp();
        $this->checkoutRequest = new CheckoutRequest();
    }

    public function test_rules()
    {
        $rules = [
            'total_products' => 'required|array',
            'total_products.*' => 'nullable|integer|min:0',
        ];

        $this->assertEquals($rules, $this->checkoutRequest->rules());
    }
}
