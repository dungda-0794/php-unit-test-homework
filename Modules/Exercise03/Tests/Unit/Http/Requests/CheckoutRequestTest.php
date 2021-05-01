<?php

namespace Modules\Exercise03\Tests\Unit\Http\Requests;

use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Tests\TestCase;

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
