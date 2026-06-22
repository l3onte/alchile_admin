<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductsCategoriesRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductsCategoriesController extends Controller
{
    public function index() {
        return view('products_categories.index');
    }

    public function store(ProductsCategoriesRequest $request) {
        ProductCategory::create($request->validated());
        return response()->json(['success' => 'Categoria agregada con exito.']);
    }

    public function update(ProductsCategoriesRequest $request, $id) 
    {
        $category = ProductCategory::findOrFail($id);
        $validated = $request->validated();
        $category->update($validated);
        return response()->json(['success' => 'Categoría actualizada con éxito.']);
    }

    public function destroy($id) { 
        $category = ProductCategory::findOrFail($id);
        $category->delete();
        return response()->json(['success' => 'Categoría eliminada con éxito.']);
    }

    public function getData() {
        $products_categories = ProductCategory::all();
        return response()->json(['data' => $products_categories]);
    }
}
