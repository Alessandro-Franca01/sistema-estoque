<?php

namespace Tests\Unit\EntryController;

use Tests\TestCase;
use App\Models\Entry;
use App\Models\Product;
use App\Models\Supplier;
use App\Helpers\EntryRuleHelper;
use Illuminate\Validation\ValidationException;

class EntryRuleHelperTest extends TestCase
{
    public function test_calculate_stock_change_with_purchased_type()
    {
        $original = [['product_id' => 1, 'quantity' => 5]];
        $new = [['product_id' => 1, 'quantity' => 8]];

        $changes = EntryRuleHelper::calculateStockChange($original, $new, 'purchased');

        $this->assertEquals(3, $changes[1]['difference']);
        $this->assertEquals(5, $changes[1]['old_quantity']);
        $this->assertEquals(8, $changes[1]['quantity']);
    }

    public function test_calculate_stock_change_with_feeding_type()
    {
        $original = [['product_id' => 1, 'quantity' => 0]];
        $new = [['product_id' => 1, 'quantity' => 5]];

        $changes = EntryRuleHelper::calculateStockChange($original, $new, 'feeding');

        $this->assertEquals(5, $changes[1]['difference']);
    }

    public function test_calculate_stock_change_with_reversal_type()
    {
        $original = [['product_id' => 1, 'quantity' => 8]];
        $new = [['product_id' => 1, 'quantity' => 5]];

        $changes = EntryRuleHelper::calculateStockChange($original, $new, 'reversal');

        $this->assertEquals(3, $changes[1]['difference']);
        $this->assertEquals(-5, $changes[1]['quantity']);
        $this->assertEquals(8, $changes[1]['old_quantity']);
    }

    public function test_get_entry_sign()
    {
        $this->assertEquals(1, EntryRuleHelper::getEntrySign('purchased'));
        $this->assertEquals(1, EntryRuleHelper::getEntrySign('feeding'));
        $this->assertEquals(-1, EntryRuleHelper::getEntrySign('reversal'));
        $this->assertEquals(1, EntryRuleHelper::getEntrySign('invalid_type'));
    }

    public function test_get_entry_sign_with_constants()
    {
        $this->assertEquals(1, EntryRuleHelper::getEntrySign(Entry::TYPE_PURCHASED));
        $this->assertEquals(1, EntryRuleHelper::getEntrySign(Entry::TYPE_FEEDING));
        $this->assertEquals(-1, EntryRuleHelper::getEntrySign(Entry::TYPE_REVERSAL));
    }

    public function test_validate_entry_type_accepts_valid_types()
    {
        EntryRuleHelper::validateEntryType(Entry::TYPE_PURCHASED, 'store');
        EntryRuleHelper::validateEntryType(Entry::TYPE_FEEDING, 'store_feeding');
        EntryRuleHelper::validateEntryType(Entry::TYPE_REVERSAL, 'store_reversal');

        $this->assertTrue(true);
    }

    public function test_validate_entry_type_rejects_invalid_type()
    {
        $this->expectException(ValidationException::class);
        EntryRuleHelper::validateEntryType('invalid_type', 'store');
    }

    public function test_validate_entry_type_rejects_wrong_action_for_type()
    {
        $this->expectException(ValidationException::class);
        EntryRuleHelper::validateEntryType(Entry::TYPE_FEEDING, 'store');
    }
}
