<?php

namespace Modules\Exercise02\Tests\Unit\Http\Requests;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Modules\Exercise02\Http\Requests\ATMRequest;

class ATMRequestTest extends TestCase
{

    public function test_rules()
    {
        $request = new ATMRequest();

        $this->assertEquals([
            'card_id' => 'required|exists:atms,card_id',
        ], $request->rules());
    }
}
