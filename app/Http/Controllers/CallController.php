<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use App\Models\Call;
use App\Models\Output;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $calls = Call::latest()->paginate(10);

        return view('calls.index', compact('calls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $outputs = Output::where('status', '!=', Output::STATUS_COMPLETED)->get();

        return view('calls.create', compact('outputs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'service_order' => 'nullable|string|max:255',
            'connect_code' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'applicant' => 'nullable|string|max:255',
            'destination' => 'required|string',
            'cep' => 'nullable|string|max:8',
            'complement' => 'nullable|string',
            'observation' => 'nullable|string',
            'output_id' => 'nullable|exists:outputs,id',
        ]);

        $call = Call::create($validated);
        // Registra a criação
        AuditHelper::logCreate($call, $request);

        return redirect()->route('calls.index')
            ->with('success', 'Chamando criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Call $call): View
    {
        $call->load('output');

        return view('calls.show', compact('call'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Call $call): View
    {
        $output = $call->output_id ? Output::find($call->output_id) : null;

        if ($output && $output->status != Output::STATUS_PENDING){
            $message = 'Chamando não pode ser editado pois o status da saida já foi concluido ou cancelado';

            return redirect()->route('calls.index')->withErrors($message);
        }

        $outputs = Output::where('status', '!=', Output::STATUS_COMPLETED)->get();

        return view('calls.edit', compact('call', 'outputs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Call $call): RedirectResponse
    {
        $oldCall = $call;

        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'service_order' => 'nullable|string|max:255',
            'connect_code' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'applicant' => 'nullable|string|max:255',
            'destination' => 'required|string',
            'cep' => 'nullable|string|max:8',
            'complement' => 'nullable|string',
            'observation' => 'nullable|string',
            'output_id' => 'nullable|exists:outputs,id',
        ]);

        $call->update($validated);

        if (class_exists(AuditHelper::class)) {
            AuditHelper::logUpdate($oldCall, $call->toArray(), $request);
        }

        return redirect()->route('calls.index')
            ->with('success', 'Call updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Call $call): RedirectResponse
    {
        $call->delete();

        return redirect()->route('calls.index')
            ->with('success', 'Call deleted successfully.');
    }
}
