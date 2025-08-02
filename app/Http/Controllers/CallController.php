<?php

namespace App\Http\Controllers;

use App\Models\Call;
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
        return view('calls.create');
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
            'caller_name' => 'nullable|string|max:255',
            'observation' => 'nullable|string',
            'output_id' => 'required|exists:outputs,id',
        ]);

        Call::create($validated);

        return redirect()->route('calls.index')
            ->with('success', 'Call created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Call $call): View
    {
        return view('calls.show', compact('call'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Call $call): View
    {
        return view('calls.edit', compact('call'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Call $call): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'service_order' => 'nullable|string|max:255',
            'connect_code' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'caller_name' => 'nullable|string|max:255',
            'observation' => 'nullable|string',
            'output_id' => 'required|exists:outputs,id',
        ]);

        $call->update($validated);

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