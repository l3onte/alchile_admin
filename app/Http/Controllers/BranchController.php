<?php

namespace App\Http\Controllers;

use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BranchController extends Controller
{
    public function index(): Response 
    {
        $branches = Branch::with(['admin' => function($query) {
                            $query->select('id', 'name');
                          }])
                          ->latest()
                          ->paginate(5);

        $admins = User::select('id', 'name')->get();

        return Inertia::render('Branches/index', [
            'branches' => $branches,
            'admins' => $admins
        ]);
    }

    public function store(BranchRequest $request): RedirectResponse
    {
        Branch::create($request->validated());

        return redirect()->route('branches.index')
                         ->with('success', 'Branch agregada con exito.');
    }

    public function update(BranchRequest $request, Branch $branch): RedirectResponse
    {
        $branch->update($request->validated());

        return redirect()->route('branches.index')
                         ->with('success', 'Branch actualizada con exito.');
    }
}
