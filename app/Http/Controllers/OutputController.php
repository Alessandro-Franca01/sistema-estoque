<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use App\Models\Output;
use App\Models\Product;
use App\Models\PublicServant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OutputController extends Controller
{
    public function index()
    {
        $outputs = Output::with(['publicServant'])->paginate(10);

        return view('outputs.index', compact('outputs'));
    }

    public function create()
    {
        $products = Product::where('quantity', '>', 0)->get();
        $public_servants = PublicServant::all()->where('job_function', 'OPERADOR');

        return view('outputs.create', compact('products', 'public_servants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'output_date' => 'required|date',
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

        // Prepare data for audit
        $jsonData = $request->all();
        unset($jsonData['_token']);
        AuditHelper::logCreateCustomData($output, $request, [], $jsonData);

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


    public function finish(Request $request, Output $output)
    {
        if ($output->is_finished) {

            return redirect()->route('outputs.index')->with('error', 'Saída ja finalizada.');
        }

        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity_used' => 'required|integer|min:0',
            'products.*.quantity_returned' => 'required|integer|min:0',
        ]);

        // Use a database transaction to ensure atomicity
        DB::transaction(function () use ($request, $output) {
            $output->load('products');

            foreach ($request->products as $productData) {
                $productId = $productData['id'];
                $quantityUsed = $productData['quantity_used'];
                $quantityReturned = $productData['quantity_returned'];

                $pivot = $output->products->where('id', $productId)->first()->pivot;

                $pivot->quantity_used = $quantityUsed;
                $pivot->quantity_returned = $quantityReturned;
                $pivot->is_finished = true; // Mark as finished
                $pivot->save();

                $product = Product::find($productId);
                $oldProduct = $product;
                if (!empty($product) && ($product->quantity >= $quantityUsed)) {
                    $product->quantity -= $quantityUsed;
                    $product->save();

                    AuditHelper::logUpdate($oldProduct, $product->toArray(), $request);
                }
            }
            $oldOutput = $output;
            $output->status = Output::STATUS_COMPLETED;
            $output->save();

            AuditHelper::logUpdateCustomData($oldOutput, $output->toArray(), $request, [], $oldOutput->toArray());
        });

        return redirect()->route('outputs.index')->with('success', 'Saída finalizada e estoque atualizado com sucesso.');
    }
}
