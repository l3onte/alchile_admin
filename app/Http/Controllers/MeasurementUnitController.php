<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeasurementUnitRequest;
use App\Models\MeasurementUnit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MeasurementUnitController extends Controller
{
    public function index(): Response
    {
        $measurementUnits = MeasurementUnit::select('id', 'name', 'abbreviation', 'is_active', 'avatar_url')
                                             ->latest()
                                             ->paginate(5);
                                
        return Inertia::render('MeasurementUnits/index', [
            'units' => $measurementUnits
        ]);
    }

    public function store(MeasurementUnitRequest $request): RedirectResponse
    {
        MeasurementUnit::create($request->validated());

        return redirect()->route('measurementunits.index')
                         ->with('success', 'La unidad se creo correctamente.');
    }

    public function update(MeasurementUnitRequest $request, MeasurementUnit $measurementunit): RedirectResponse
    {
        $measurementunit->update($request->validated());

        return redirect()->route('measurementunits.index')
                         ->with('success', 'La unidad se actualizó correctamente.');
    }
}
