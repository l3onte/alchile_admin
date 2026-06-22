<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index() {
        $users = User::all();
        return view('branches.index', compact('users'));
    }

    public function store(BranchRequest $request) {
        Branch::create($request->validated());
        return response()->json(['success' => 'Sucursal creada con exito.']);
    }

    public function update(BranchRequest $request, Branch $branch) {
        $branch->updateOrFail($request->validated());
        return response()->json(['success' => 'Sucursal actualizada con exito.']);
    }

    public function destroy(Branch $branch) {
        $branch->delete();
        return response()->json(['success' => 'Sucursal eliminada con exito.']);
    }

    public function getData() {
        $branches = Branch::with('user')->get();
        return response()->json(['data' => $branches]);
    }
}
