<?php

namespace App\Http\Controllers;

use App\Models\MeasurementType;
use App\Http\Requests\StoreMeasurementTypeRequest;
use App\Http\Requests\UpdateMeasurementTypeRequest;
use Illuminate\Http\Request;

class MeasurementTypeController extends Controller
{
    public function index()
    {
        $measurementTypes = MeasurementType::paginate(15);
        return view('measurement_types.index', compact('measurementTypes'));
    }

    public function create()
    {
        return view('measurement_types.create');
    }

    public function store(StoreMeasurementTypeRequest $request)
    {
        MeasurementType::create($request->validated());
        return redirect()->route('measurement-types.index')->with('success', 'Tipo de Medida criado com sucesso.');
    }

    public function show(MeasurementType $measurementType)
    {
        return view('measurement_types.show', compact('measurementType'));
    }

    public function edit(MeasurementType $measurementType)
    {
        return view('measurement_types.edit', compact('measurementType'));
    }

    public function update(UpdateMeasurementTypeRequest $request, MeasurementType $measurementType)
    {
        $measurementType->update($request->validated());
        return redirect()->route('measurement-types.index')->with('success', 'Tipo de Medida atualizado com sucesso.');
    }

    public function destroy(MeasurementType $measurementType)
    {
        $measurementType->delete();
        return redirect()->route('measurement-types.index')->with('success', 'Tipo de Medida excluído com sucesso.');
    }
} 