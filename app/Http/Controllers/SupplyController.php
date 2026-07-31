<?php

namespace App\Http\Controllers;

use App\Enums\SupplyMovementType;
use App\Http\Requests\SupplyRequest;
use App\Models\Supply;
use App\Models\SupplyMovement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupplyController extends Controller
{
    public function store(SupplyRequest $request): RedirectResponse
    {
        $supplySelectedId = $request->input('supply_selected_id');
        $branchId = $request->input('branch_id');
        $userId = $request->input('user_id') ?? Auth::id();
        $quantity = $request->input('quantity', 0);
        $description = $request->input('description');

        if ($supplySelectedId) {
            $supplySelected = Supply::findOrFail($supplySelectedId);

            if ($quantity > 0) {
                SupplyMovement::create([
                    'user_id'   => $userId,
                    'branch_id' => $branchId,
                    'supply_id' => $supplySelected->id,
                    'movement_type' => SupplyMovementType::INPUT_PURCHASE->value,
                    'description' => $description ?? 'Incremento de Stock a producto existente.',
                    'quantity' => $quantity
                ]);
            }

            return redirect()->route('inventory.index')
                             ->with('success', 'Nueva entrada de inventario registrada exitosamente.');
        }

        DB::transaction(function () use ($request, $branchId, $userId, $quantity, $description) {
            $supply = Supply::create($request->validated());

            if ($quantity > 0) {
                SupplyMovement::create([
                    'user_id' => $userId,
                    'branch_id' => $branchId,
                    'supply_id' => $supply->id,
                    'movement_type' => SupplyMovementType::INPUT_PURCHASE->value,
                    'description' => $description ?? 'Registro de stock inicial.',
                    'quantity' => $quantity
                ]);
            }
        });

        return redirect()->route('inventory.index')
                         ->with('success', 'Insumo creado e inventario inicial creado.');

    }

    public function update(SupplyRequest $request, Supply $supply): RedirectResponse
    {
        $branchId = $request->input('branch_id');
        $userId = $request->input('user_id') ?? Auth::id();
        $quantity = $request->input('quantity');
        $description = $request->input('description');

        DB::transaction(function () use ($request, $branchId, $supply, $userId, $quantity, $description) {
            $supply->update($request->validated());

            if ($quantity != null) {
                $firstMovement = SupplyMovement::where('supply_id', $supply->id)
                                                ->orderBy('created_at', 'asc')
                                                ->first();
                
                if ($firstMovement) {
                    $firstMovement->update([
                        'quantity' => (float) $quantity,
                        'branch_id' => $branchId ?? $firstMovement->branch_id,
                        'user_id' => $userId,
                        'description' => $description ?? $firstMovement->description
                    ]);
                } else if ((float) $quantity > 0) { 
                    SupplyMovement::create([
                        'user_id' => $userId,
                        'branch_id' => $branchId,
                        'supply_id' => $supply->id,
                        'movement_type' => SupplyMovementType::INPUT_PURCHASE->value,
                        'description' => $description ?? 'Registro de stock inicial (desde actualización).',
                        'quantity' => (float) $quantity
                    ]);
                }
            }
        });

        return redirect()->route('inventory.index')
                         ->with('success', 'El ingrediente y su inventario se actualizaron correctamente.');
    }
}
