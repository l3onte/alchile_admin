<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\ProductMovement;
use App\Models\SupplyMovement;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MovementsController extends Controller
{
    public function index(Request $request): Response
    {
        $branchId = $request->query('branch_id', 'all');
        $branches = Branch::select('id', 'branch_name')->get();

        $QueryProductMovements = ProductMovement::with([
            'user:id,name',
            'branch:id,branch_name',
            'product' => function ($query) {
                $query->select('id', 'name', 'measurement_unit_id')
                    ->with('measurement_unit:id,name,abbreviation');
            }
        ])->select(
            'id',
            'user_id',
            'branch_id',
            'product_id',
            'quantity',
            'movement_type',
            'description',
            'created_at'
        )
            ->selectSub(function ($query) use ($branchId) {
                $query->from('product_movements as pm_sub')
                    ->selectRaw("COALESCE(SUM(
                    CASE
                        WHEN movement_type LIKE 'input_%' THEN quantity
                        WHEN movement_type LIKE 'output_%' THEN -quantity
                    END
                ), 0)")
                    ->whereColumn('pm_sub.product_id', 'product_movements.product_id');

                if ($branchId !== 'all') {
                    $query->where('pm_sub.branch_id', $branchId);
                }
            }, 'current_stock');

        $QuerySuppliesMovements = SupplyMovement::with([
            'user:id,name',
            'branch:id,branch_name',
            'supply' => function ($query) {
                $query->select('id', 'name', 'measurement_unit_id')
                    ->with('measurement_unit:id,name,abbreviation');
            }
        ])->select(
            'id',
            'user_id',
            'branch_id',
            'supply_id',
            'quantity',
            'movement_type',
            'description',
            'created_at'
        )
            ->selectSub(function ($query) use ($branchId) {
                $query->from('supply_movements as sm_sub')
                    ->selectRaw("COALESCE(SUM(
                    CASE
                        WHEN movement_type LIKE 'input_%' THEN quantity
                        WHEN movement_type LIKE 'output_%' THEN -quantity
                    END
                ), 0)")
                    ->whereColumn('sm_sub.supply_id', 'supply_movements.supply_id');

                if ($branchId !== 'all') {
                    $query->where('sm_sub.branch_id', $branchId);
                }
            }, 'current_stock');

        if ($branchId !== 'all') {
            $QueryProductMovements->where('branch_id', $branchId);
            $QuerySuppliesMovements->where('branch_id', $branchId);
        }

        $ProductMovements = $QueryProductMovements->latest()->paginate(5, ['*'], 'products_page')->appends($request->query());
        $SuppliesMovements = $QuerySuppliesMovements->latest()->paginate(5, ['*'], 'supply_page')->appends($request->query());

        return Inertia::render('Movements/index', [
            'ProductMovements' => $ProductMovements,
            'SuppliesMovements' => $SuppliesMovements,
            'branches' => $branches
        ]);
    }
}
