<?php

namespace App\Http\Controllers;

use App\Models\Output;
use App\Models\Product;
use App\Models\PublicServant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OutputController extends Controller
{
    public function index()
    {
        $outputs = Output::with(['publicServant'])->get();

        return view('outputs.index', compact('outputs'));
    }

    public function create()
    {
        $products = Product::all();
        $public_servants = PublicServant::all();

        return view('outputs.create', compact('products', 'public_servants'));
    }

    public function store(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'output_date' => 'required|date',
//            'call_type' => 'required|string',
//            'caller_name' => 'nullable|string|max:255',
//            'destination' => 'nullable|string',
            'public_servant_id' => 'required|exists:public_servants,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $output = Output::create($request->only([
            'output_date',
//            'call_type',
//            'caller_name',
//            'destination',
            'public_servant_id',
        ]));

        foreach ($request->products as $product) {
            $output->products()->attach($product['product_id'], [
                'quantity' => $product['quantity'],
                'quantity_used' => 0,
                'quantity_returned' => 0,
                'is_finished' => false,
                'observation' => null,
            ]);
        }

        return redirect()->route('outputs.index')->with('success', 'Saída registrada com sucesso.');
    }

    public function show(Output $output)
    {
        $output->load(['products', 'publicServant']);
        return view('outputs.show', compact('output'));
    }

    public function edit(Output $output)
    {
        $products = Product::all();
        $public_servants = PublicServant::all();
        $output->load('products');
        return view('outputs.edit', compact('output', 'products', 'public_servants'));
    }

    public function update(Request $request, Output $output)
    {
        $request->validate([
            'output_date' => 'required|date',
            'call_type' => 'required|string',
            'caller_name' => 'nullable|string|max:255',
            'destination' => 'nullable|string',
            'public_servant_id' => 'required|exists:public_servants,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $output->update($request->only([
            'output_date',
            'call_type',
            'caller_name',
            'destination',
            'public_servant_id',
        ]));

        $output->products()->detach();
        foreach ($request->products as $product) {
            $output->products()->attach($product['product_id'], ['quantity' => $product['quantity']]);
        }

        return redirect()->route('outputs.index')->with('success', 'Saída atualizada com sucesso.');
    }

    public function destroy(Output $output)
    {
        $output->delete();

        return redirect()->route('outputs.index')->with('success', 'Saída excluída com sucesso.');
    }

    // Step 1: Implement the finish method
    // TODO: Testando com somente um produto
    public function finish(Request $request, Output $output)
    {
//        dd($request->all(), $output);
        // Step 2: Validate the incoming request for product updates
        // TODO: Melhorar as validações e add uma Segunda camada
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity_used' => 'required|integer|min:0',
            'products.*.quantity_returned' => 'required|integer|min:0',
        ]);

        // Use a database transaction to ensure atomicity
        DB::transaction(function () use ($request, $output) {
            // Step 3: Load the pivot data for the output's products
            $output->load('products');

            foreach ($request->products as $productData) {
                $productId = $productData['id'];
                $quantityUsed = $productData['quantity_used'];
                $quantityReturned = $productData['quantity_returned'];

                // Find the pivot record for the current product
                $pivot = $output->products->where('id', $productId)->first()->pivot;

                // Step 4: Update the ProductOutput pivot table
                $pivot->quantity_used = $quantityUsed;
                $pivot->quantity_returned = $quantityReturned;
                $pivot->is_finished = true; // Mark as finished
                $pivot->save();

                // Step 5: Update the actual product's stock quantity
                $product = Product::find($productId);
                if ($product) {
                    // Subtract only the quantity used from the product's stock
                    $product->quantity -= $quantityUsed;
                    $product->save();
                }
            }

            // Step 6: Update the Output status to completed
            $output->status = Output::STATUS_COMPLETED;
            $output->save();
        });

        // Step 7: Redirect with a success message
        return redirect()->route('outputs.index')->with('success', 'Saída finalizada e estoque atualizado com sucesso.');
    }
}
