<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SupplierController extends Controller
{
    public function index(): Response
    {
        $suppliers = Supplier::select('id', 'contact_name', 'name', 'phone', 'email', 'is_active')
                               ->latest()
                               ->paginate(5);
        
        return Inertia::render('Suppliers/index', [
            'suppliers' => $suppliers
        ]);      
    }

    public function store(SupplierRequest $request): RedirectResponse
    {
        Supplier::create($request->validated());

        return redirect()->route('suppliers.index')
                         ->with('success', 'La sucursal se creo correctamente.');

    }

    public function update(SupplierRequest $request, Supplier $supplier): RedirectResponse
    {
        $supplier->update($request->validated());

        return redirect()->route('suppliers.index')
                         ->with('success', 'La sucursal fue actualizada con exito.');
    }
}
