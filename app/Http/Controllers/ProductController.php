<?php

namespace App\Http\Controllers;

use App\Enums\ProductMovementType;
use App\Http\Requests\ProductRequest;
use App\Models\BranchProduct;
use App\Models\Product;
use App\Models\ProductMovement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function store(ProductRequest $request): RedirectResponse
    {
        $userId = $request->input('user_id') ?? Auth::id();
        $branchId = $request->input('branch_id');
        $quantity = $request->input('quantity', 0);
        $description = $request->input('description');
        $minStock = $request->input('min_stock');
        $unitCost = $request->input('unit_cost');
        
        $productSelectedId = $request->input('product_selected_id');

        if ($productSelectedId) {
            DB::transaction(function () use ($userId, $branchId, $quantity, $description, $minStock, $unitCost, $productSelectedId) {
                $productBranch = BranchProduct::firstOrNew([
                    'branch_id' => $branchId,
                    'product_id' => $productSelectedId
                ]);

                $productBranch->quantity = $productBranch->exists ? $productBranch->quantity  + $quantity : $quantity;
                if ($minStock) $productBranch->min_stock = $minStock;
                if ($unitCost) $productBranch->price = $unitCost;
                $productBranch->status = 1;
                $productBranch->save();

                if ($quantity > 0) {
                    ProductMovement::create([
                        'user_id' => $userId,
                        'branch_id' => $branchId,
                        'product_id' => $productSelectedId,
                        'quantity' => $quantity,
                        'movement_type' => ProductMovementType::INPUT_PURCHASE->value,
                        'description' => $description ?? 'Incremento de cantidad a producto existente.'
                    ]);
                }
            });

            return redirect()->route('inventory.index')
                             ->with('success', 'Nueva entrada al inventario registrada exitosamente.');
        }

        DB::transaction(function () use ($minStock, $request, $unitCost, $userId, $branchId, $quantity, $description) {
            $newProduct = Product::create($request->validated());

            BranchProduct::create([
                'branch_id' => $branchId,
                'product_id' => $newProduct->id,
                'quantity' => $quantity,
                'min_stock' => $minStock,
                'price' => $unitCost,
                'status' => 1
            ]);

            if ($quantity > 0) {
                ProductMovement::create([
                    'user_id' => $userId,
                    'branch_id' => $branchId,
                    'product_id' => $newProduct->id,
                    'quantity' => $quantity,
                    'movement_type' => ProductMovementType::INPUT_PURCHASE->value,
                    'description' => $description ?? 'Registro Stock inicial.',
                ]);
            }
        });

        return redirect()->route('inventory.index')
                         ->with('success', 'Producto creado y agregado al inventario.');
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $branchId = $request->input('branch_id');
        $quantity = $request->input('quantity');
        $minStock = $request->input('min_stock');
        $unitCost = $request->input('unit_cost');

        DB::transaction(function () use ($minStock, $request, $unitCost, $branchId, $quantity, $product) {
            $product->update($request->validated());

            if ($branchId) {
                $branchData = [];
                if ($quantity !== null && $quantity !== '') $branchData['quantity'] = $quantity;
                if ($minStock !== null && $minStock !== '') $branchData['min_stock'] = $minStock;
                if ($unitCost !== null && $unitCost !== '') $branchData['price'] = $unitCost;

                if (!empty($branchData)) {
                    BranchProduct::updateOrCreate(
                        [
                            'branch_id' => $branchId,
                            'product_id' => $product->id
                        ],
                        $branchData
                    );
                }
            }
        });

        return redirect()->route('inventory.index')
                         ->with('success', 'El producto y su inventario se actualizo correctamente.');
    }
}
