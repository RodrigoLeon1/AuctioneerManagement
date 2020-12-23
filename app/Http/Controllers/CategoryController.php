<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::paginate('10');
        $categoriesDeleted = Category::onlyTrashed()->get();
        return view('categorias.index', compact('categories', 'categoriesDeleted'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        Category::create([
            'description' => $request->input('description')
        ]);

        return redirect()
            ->route('categorias.index')
            ->with('success-store', 'Su categoría ha sido creada de manera exitosa.');
    }

    public function show($id)
    {
        $category = Category::find($id);
        return view('categorias.show', compact('category'));
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('categorias.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        Category::where('id', $id)->update(
            ['description' => $request->input('description')]
        );

        return redirect()
            ->back()
            ->with('success-update', 'Categoría modificada de manera exitosa.');
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();

        return redirect()
            ->route('categorias.index')
            ->with('success-destroy', 'Categoría eliminada con éxito.');
    }

    public function restore($id)
    {
        Category::withTrashed()
            ->where('id', $id)
            ->restore();

        return redirect()
            ->route('categorias.index')
            ->with('success-restore', 'Categoría activada con éxito.');
    }
}
