<?php

namespace Modules\Exercise02\Tests\Unit\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use Modules\Exercise02\Http\Requests\ATMRequest;

class ATMRequestTest extends TestCase
{
    protected $aTMRequest;

    public function setUp(): void
    {
        parent::setUp();
        $this->aTMRequest = new ATMRequest();
    }

    public function test_validate_fails()
    {
        $validator = Validator::make([], $this->aTMRequest->rules());
        $this->assertTrue($validator->fails());
    }

    public function test_rules_pass()
    {
        $rules = [
            'card_id' => 'required|exists:atms,card_id',
        ];

        $this->assertEquals($rules, $this->aTMRequest->rules());
    }
}
