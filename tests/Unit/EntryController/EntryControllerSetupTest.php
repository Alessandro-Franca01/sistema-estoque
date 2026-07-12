<?php

namespace Tests\Unit\EntryController;

use Tests\TestCase;
use App\Http\Controllers\EntryController;

class EntryControllerSetupTest extends TestCase
{
    public function test_controller_has_all_expected_methods()
    {
        $controller = new EntryController();

        $methods = [
            'index',
            'create',
            'store',
            'show',
            'edit',
            'update',
            'createReversal',
            'storeReversal',
            'createFeeding',
            'storeFeeding',
        ];

        foreach ($methods as $method) {
            $this->assertTrue(
                method_exists($controller, $method),
                "Method {$method} should exist"
            );
        }
    }
}
