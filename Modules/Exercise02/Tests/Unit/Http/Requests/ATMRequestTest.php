<?php

namespace Modules\Exercise02\Tests\Unit\Http\Requests;

use Tests\TestCase;
use Modules\Exercise02\Http\Requests\ATMRequest;

class ATMRequestTest extends TestCase
{
    protected $atmRequest;

    public function setUp(): void
    {
        parent::setUp();
        $this->atmRequest = new ATMRequest();
    }

    public function test_rules()
    {
        $rules = [
            'card_id' => 'required|exists:atms,card_id',
        ];

        $this->assertEquals($rules, $this->atmRequest->rules());
    }
}