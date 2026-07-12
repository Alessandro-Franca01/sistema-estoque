<?php

namespace Tests\Feature\EntryController;

use Tests\TestCase;
use App\Models\Entry;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntryWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_complete_entry_workflow_create_and_reverse()
    {
        $supplier = Supplier::factory()->create();
        $product = Product::factory()->create(['quantity' => 0]);

        $entryData = [
            'entry_type' => Entry::TYPE_PURCHASED,
            'supplier_id' => $supplier->id,
            'entry_date' => now()->format('Y-m-d'),
            'invoice_number' => 'NF-12345',
            'value' => 500.00,
            'products' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 10,
                    'unit_cost' => 50.00,
                ],
            ],
        ];

        $response = $this->post(route('entries.store'), $entryData);
        $response->assertRedirect();

        $entry = Entry::where('entry_type', Entry::TYPE_PURCHASED)->first();
        $this->assertNotNull($entry);

        $product->refresh();
        $this->assertEquals(10, $product->quantity);

        $response = $this->post(route('entries.reversal'), [
            'entry' => $entry->id,
            'observation' => 'Reversão de teste de workflow',
        ]);
        $response->assertRedirect();

        $entry->refresh();
        $this->assertEquals(Entry::TYPE_REVERSAL, $entry->entry_type);

        $product->refresh();
        $this->assertEquals(0, $product->quantity);
    }

    public function test_entry_update_workflow_with_stock_changes()
    {
        $supplier = Supplier::factory()->create();
        $product = Product::factory()->create(['quantity' => 0]);

        $entry = Entry::factory()->purchased()->create([
            'supplier_id' => $supplier->id,
        ]);

        $entry->products()->attach($product->id, [
            'entry_id' => $entry->id,
            'quantity' => 5,
            'unit_cost' => 25.00,
            'total_cost' => 125.00,
        ]);

        $product->refresh();
        $this->assertEquals(5, $product->quantity);

        $updateData = [
            'entry_type' => Entry::TYPE_PURCHASED,
            'entry_date' => now()->format('Y-m-d'),
            'invoice_number' => 'NF-99999',
            'value' => 1000.00,
            'supplier_id' => $supplier->id,
            'products' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 8,
                    'unit_cost' => 50.00,
                ],
            ],
        ];

        $response = $this->put(route('entries.update', $entry), $updateData);
        $response->assertRedirect();

        $product->refresh();
        $this->assertEquals(8, $product->quantity);

        $this->assertDatabaseHas('product_entries', [
            'entry_id' => $entry->id,
            'product_id' => $product->id,
            'quantity' => 8,
        ]);
    }

    public function test_feed_multiple_products()
    {
        $product1 = Product::factory()->outOfStock()->create();
        $product2 = Product::factory()->outOfStock()->create();

        $data = [
            'entry_type' => Entry::TYPE_FEEDING,
            'entry_date' => now()->format('Y-m-d'),
            'products' => [
                [
                    'product_id' => $product1->id,
                    'quantity' => 3,
                    'unit_cost' => 0,
                ],
                [
                    'product_id' => $product2->id,
                    'quantity' => 7,
                    'unit_cost' => 0,
                ],
            ],
        ];

        $response = $this->post(route('entries.feeding'), $data);
        $response->assertRedirect();

        $product1->refresh();
        $product2->refresh();
        $this->assertEquals(3, $product1->quantity);
        $this->assertEquals(7, $product2->quantity);
    }
}
