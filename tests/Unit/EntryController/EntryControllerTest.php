<?php

namespace Tests\Unit\EntryController;

use Tests\TestCase;
use App\Models\User;
use App\Models\Entry;
use App\Models\Product;
use App\Models\Supplier;

class EntryControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    protected function getValidEntryData(array $overrides = []): array
    {
        return array_merge([
            'entry_type' => Entry::TYPE_PURCHASED,
            'supplier_id' => Supplier::factory()->create()->id,
            'entry_date' => now()->format('Y-m-d'),
            'invoice_number' => 'NF-12345',
            'value' => 500.00,
            'products' => [
                [
                    'product_id' => Product::factory()->create(['quantity' => 0])->id,
                    'quantity' => 5,
                    'unit_cost' => 25.00,
                ],
            ],
        ], $overrides);
    }

    protected function createEntryProduct(Entry $entry, Product $product, int $quantity, float $unitCost = 0.00): void
    {
        $entry->products()->attach($product->id, [
            'entry_id' => $entry->id,
            'quantity' => $quantity,
            'unit_cost' => $unitCost,
            'total_cost' => $quantity * $unitCost,
        ]);
    }

    public function test_index_displays_entries()
    {
        $response = $this->get(route('entries.index'));
        $response->assertOk();
        $response->assertViewIs('entries.index');
    }

    public function test_create_displays_form()
    {
        $response = $this->get(route('entries.create'));
        $response->assertOk();
        $response->assertViewIs('entries.create');
    }

    public function test_show_displays_entry_details()
    {
        $entry = Entry::factory()->create(['entry_type' => Entry::TYPE_PURCHASED]);

        $response = $this->get(route('entries.show', $entry));

        $response->assertOk();
        $response->assertViewIs('entries.show');
        $response->assertViewHas('entry');
    }

    public function test_edit_displays_form()
    {
        $entry = Entry::factory()->create(['entry_type' => Entry::TYPE_PURCHASED]);

        $response = $this->get(route('entries.edit', $entry));

        $response->assertOk();
        $response->assertViewIs('entries.edit');
    }

    public function test_store_creates_purchased_entry()
    {
        $supplier = Supplier::factory()->create();
        $product = Product::factory()->create(['quantity' => 0]);
        $initialStock = $product->quantity;

        $data = $this->getValidEntryData([
            'supplier_id' => $supplier->id,
            'products' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 10,
                    'unit_cost' => 50.00,
                    'batch_item' => 'BATCH001',
                ],
            ],
        ]);

        $response = $this->post(route('entries.store'), $data);

        $entry = Entry::where('entry_type', Entry::TYPE_PURCHASED)->first();
        $this->assertNotNull($entry);

        $product->refresh();
        $this->assertEquals($initialStock + 10, $product->quantity);

        $this->assertDatabaseHas('product_entries', [
            'entry_id' => $entry->id,
            'product_id' => $product->id,
            'quantity' => 10,
            'unit_cost' => 50.00,
        ]);

        $response->assertRedirect(route('entries.index'));
    }

    public function test_store_requires_products()
    {
        $data = $this->getValidEntryData(['products' => []]);

        $response = $this->post(route('entries.store'), $data);

        $response->assertSessionHasErrors('products');
    }

    public function test_store_requires_valid_product_id()
    {
        $data = $this->getValidEntryData([
            'products' => [
                [
                    'product_id' => 99999,
                    'quantity' => 5,
                    'unit_cost' => 10.00,
                ],
            ],
        ]);

        $response = $this->post(route('entries.store'), $data);

        $response->assertSessionHasErrors('products.0.product_id');
    }

    public function test_store_requires_positive_quantity()
    {
        $product = Product::factory()->create(['quantity' => 0]);

        $data = $this->getValidEntryData([
            'products' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 0,
                    'unit_cost' => 10.00,
                ],
            ],
        ]);

        $response = $this->post(route('entries.store'), $data);

        $response->assertSessionHasErrors('products.0.quantity');
    }

    public function test_create_feeding_displays_form()
    {
        $response = $this->get(route('entries.feeding.create'));
        $response->assertOk();
        $response->assertViewIs('entries.feeding');
    }

    public function test_store_feeding_creates_entry()
    {
        $product = Product::factory()->create(['quantity' => 0]);

        $data = $this->getValidEntryData([
            'entry_type' => Entry::TYPE_FEEDING,
            'invoice_number' => null,
            'products' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 5,
                    'unit_cost' => 10.00,
                ],
            ],
        ]);

        $response = $this->post(route('entries.feeding'), $data);

        $entry = Entry::where('entry_type', Entry::TYPE_FEEDING)->first();
        $this->assertNotNull($entry);

        $product->refresh();
        $this->assertEquals(5, $product->quantity);

        $response->assertRedirect(route('entries.index'));
    }

    public function test_create_reversal_displays_form()
    {
        Entry::factory()->purchased()->create();

        $response = $this->get(route('entries.reversal.create'));
        $response->assertOk();
        $response->assertViewIs('entries.reversal');
    }

    public function test_store_reversal_reverts_stock()
    {
        $entry = Entry::factory()->purchased()->create(['observation' => null]);
        $product = Product::factory()->create(['quantity' => 0]);

        $this->createEntryProduct($entry, $product, 10, 25.00);
        $product->refresh();
        $this->assertEquals(10, $product->quantity);

        $response = $this->post(route('entries.reversal'), [
            'entry' => $entry->id,
            'observation' => 'Reversão de teste',
        ]);

        $entry->refresh();
        $this->assertEquals(Entry::TYPE_REVERSAL, $entry->entry_type);

        $product->refresh();
        $this->assertEquals(0, $product->quantity);

        $response->assertRedirect(route('entries.index'));
    }

    public function test_update_stock_increase()
    {
        $entry = Entry::factory()->purchased()->create();
        $product = Product::factory()->create(['quantity' => 10]);

        $this->createEntryProduct($entry, $product, 5);

        $data = [
            'entry_type' => Entry::TYPE_PURCHASED,
            'entry_date' => now()->format('Y-m-d'),
            'invoice_number' => 'NF-99999',
            'value' => 1000.00,
            'supplier_id' => Supplier::factory()->create()->id,
            'products' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 10,
                    'unit_cost' => 50.00,
                ],
            ],
        ];

        $response = $this->put(route('entries.update', $entry), $data);

        $product->refresh();
        $this->assertEquals(20, $product->quantity);
    }

    public function test_update_stock_decrease()
    {
        $entry = Entry::factory()->purchased()->create();
        $product = Product::factory()->create(['quantity' => 10]);

        $this->createEntryProduct($entry, $product, 5);

        $data = [
            'entry_type' => Entry::TYPE_PURCHASED,
            'entry_date' => now()->format('Y-m-d'),
            'invoice_number' => 'NF-99999',
            'value' => 1000.00,
            'supplier_id' => $entry->supplier_id ?? Supplier::factory()->create()->id,
            'products' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                    'unit_cost' => 50.00,
                ],
            ],
        ];

        $response = $this->put(route('entries.update', $entry), $data);

        $product->refresh();
        $this->assertEquals(12, $product->quantity);
    }
}
