<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\MeasurementUnit;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Supply;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class InventoryController extends Controller
{
    public function index(Request $request): Response
    {
        $branchId = $request->input('branch_id', 'all');

        $branches = Branch::select('id', 'branch_name')->get();
        $suppliers = Supplier::select('id', 'name')->get();
        $units = MeasurementUnit::select('id', 'name')->get();

        $suppliesQuery = Supply::with([
            'measurement_unit' => function($query) {
                $query->select('id', 'name', 'abbreviation');
            },
            'supplier' => function($query) {
                $query->select('id', 'name');
            }
        ])
        ->select('id', 'supplier_id', 'name', 'measurement_unit_id', 'status', 'created_at')
        ->selectSub(function ($query) use ($branchId) {
            $query->from('supply_movements')
                ->selectRaw("COALESCE(SUM(
                    CASE
                        WHEN movement_type LIKE 'input_%' THEN quantity
                        WHEN movement_type LIKE 'output_%' THEN -quantity
                        ELSE 0
                    END
                ), 0)")
                ->whereColumn('supply_movements.supply_id', 'supplies.id');

                if ($branchId !== 'all') {
                    $query->where('branch_id', $branchId);
                }
        }, 'current_stock')
        ->selectSub(function ($query) use ($branchId) {
            $query->from('branch_supplies')
                  ->select('branch_id')
                  ->whereColumn('branch_supplies.supply_id', 'supplies.id');

                  if ($branchId != 'all') {
                    $query->where('branch_id', $branchId);
                  } else {
                    $query->limit(1);
                  }
        }, 'branch_id')
        ->selectSub(function ($query) use ($branchId) {
            $query->from('branch_supplies')
                ->select('min_stock')
                ->whereColumn('branch_supplies.supply_id', 'supplies.id');

                if ($branchId != 'all') {
                    $query->where('branch_id', $branchId);
                } else {
                    $query->limit(1);
                }
        }, 'min_stock')
        ->selectSub(function ($query) use ($branchId) {
            $query->from('branch_supplies')
                ->select('unit_cost')
                ->whereColumn('branch_supplies.supply_id', 'supplies.id');

                if ($branchId != 'all') {
                    $query->where('branch_id', $branchId);
                } else {
                    $query->limit(1);
                }
        }, 'unit_cost');

        if ($branchId !== 'all') {
            $suppliesQuery->whereHas('supply_movements', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }

        $suppliesQuery->latest('id');

        $productsQuery = Product::with([
            'measumeasurement_unit' => function ($query) {
                $query->select('id', 'name', 'abbreviation');
            }
        ])
        ->select('id', 'name', 'is_reventa', 'measurement_unit_id', 'status', 'created_at')
        ->selectSub(function ($query) use ($branchId) {
            $query->from('product_movements')
                ->selectRaw("COALESCE(SUM(
                    CASE 
                        WHEN movement_type LIKE 'input_%' THEN quantity
                        WHEN movement_type LIKE 'output_%' THEN -quantity
                        ELSE 0
                    END
                ), 0)")
                ->whereColumn('product_movements.product_id', 'products.id');
                if ($branchId !== 'all') {
                    $query->where('branch_id', $branchId);
                }
        }, 'current_stock')
        ->selectSub(function ($query) use ($branchId) {
            $query->from('branch_products')
                  ->select('branch_id')
                  ->whereColumn('branch_products.product_id', 'products.id');

                  if ($branchId != 'all') {
                    $query->where('branch_id', $branchId);
                  } else {
                    $query->limit(1);
                  }
        }, 'branch_id')
        ->selectSub(function ($query) use ($branchId) {
            $query->from('branch_products')
                ->select('min_stock')
                ->whereColumn('branch_products.product_id', 'products.id');
                if ($branchId != 'all') {
                    $query->where('branch_id', $branchId);
                } else {
                    $query->limit(1);
                }
        }, 'min_stock')
        ->selectSub(function ($query) use ($branchId) {
            $query->from('branch_products')
                ->select('price')
                ->whereColumn('branch_products.product_id', 'products.id');
                if ($branchId != 'all') {
                    $query->where('branch_id', $branchId);
                } else {
                    $query->limit(1);
                }
        }, 'price')
        ->where('is_reventa', true);

        if ($branchId !== 'all') {
            $productsQuery->whereHas('product_movements', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }

        $productsQuery->latest('id');

        $supplies = $suppliesQuery->paginate(5, ['*'], 'supplies_page')->appends($request->query());
        $products = $productsQuery->paginate(5, ['*'], 'products_page')->appends($request->query());

        return Inertia::render('Inventory/index', [
            'branches' => $branches,
            'supplies' => $supplies,
            'products' => $products,
            'suppliers' => $suppliers,
            'units' => $units,
            'selectedBranch' => $branchId
        ]);
    }
}
