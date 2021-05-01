<?php

namespace Modules\Exercise02\Tests\Unit\Http\Requests;

use Modules\Exercise02\Http\Requests\ATMRequest;
use Tests\TestCase;

class ATMRequestTest extends TestCase
{
    protected $aTMRequest;

    public function setUp(): void
    {
        parent::setUp();
        $this->aTMRequest = new ATMRequest();
    }

    public function test_rules()
    {
        $rules = [
            'card_id' => 'required|exists:atms,card_id',
        ];

        $this->assertEquals($rules, $this->aTMRequest->rules());
    }
}