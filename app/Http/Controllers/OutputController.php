<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use App\Models\Output;
use App\Models\Product;
use App\Models\PublicServant;
use App\Models\Call;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Support\Tenant;

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
        $public_servants = PublicServant::join('public_servant_departments', 'public_servant_departments.public_servant_id', '=', 'public_servants.id')
            ->where('public_servant_departments.job_function', 'OPERADOR')
            ->where(function ($q) {
                if (Tenant::id()) {
                    $q->where('public_servant_departments.department_id', Tenant::id());
                }
            })
            ->select('public_servants.*')
            ->distinct()
            ->get();

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
            'applicant' => 'nullable|string|max:255',
            'destination' => 'nullable|string',
            'public_servant_id' => 'required|exists:public_servants,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $output->update($request->only([
            'output_date',
            'call_type',
            'applicant',
            'destination',
            'public_servant_id',
        ]));

        $output->products()->detach();
        foreach ($request->products as $product) {
            $output->products()->attach($product['product_id'], ['quantity' => $product['quantity']]);
        }

        return redirect()->route('outputs.index')->with('success', 'Saída atualizada com sucesso.');
    }

    // TODO: Fazer todos os testes nesse metodo antes de colocar em Produção
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

            // Atualziando os produtos
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

            // Atualizar status do(s) chamado(s) relacionado(s) para 'finished'
            Call::where('output_id', $output->id)->where('status', Call::STATUS_IN_PROGRESS)->update(['status' => Call::STATUS_FINISHED]);

            AuditHelper::logUpdateCustomData($oldOutput, $output->toArray(), $request, [], $oldOutput->toArray());
        });

        return redirect()->route('outputs.index')->with('success', 'Saída finalizada e estoque atualizado com sucesso.');
    }

    /**
     * Cancelar uma Saída: atualiza o status para 'canceled', marca chamados relacionados como 'canceled' e registra auditoria.
     */
    public function cancel(Request $request, Output $output)
    {
        // Impede cancelar uma saída já concluída
        if ($output->status === Output::STATUS_COMPLETED) {
            return redirect()->route('outputs.index')->withErrors('Saída já finalizada não pode ser cancelada.');
        }

        // Caso já esteja cancelada
        if ($output->status === Output::STATUS_CANCELED) {
            return redirect()->route('outputs.index')->with('info', 'Saída já está cancelada.');
        }

        $oldValues = $output->toArray();
        $output->status = Output::STATUS_CANCELED;
        $output->save();

        // Atualizar status do(s) chamado(s) relacionado(s) para 'canceled'
        Call::where('output_id', $output->id)
            ->where('status', 'in_progress')
            ->update(['status' => 'canceled']);

        // Registrar auditoria com valores antigos e novos explícitos
        if (class_exists(AuditHelper::class)) {
            AuditHelper::logUpdateCustomData($output, $output->toArray(), $request, [], $oldValues);
        }

        return redirect()->route('outputs.index')->with('success', 'Saída cancelada com sucesso.');
    }
}

