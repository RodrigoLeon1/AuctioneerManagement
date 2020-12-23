<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::paginate('10');
        return view('productos.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::find($id);
        return view('productos.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        return view('productos.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::find($id);
        $product->update(
            ['description' => $request->input('description')]
        );
        $product->categories()->sync($request->input('category'));

        return redirect()
            ->back()
            ->with('success-update', 'Mercadería modificada de manera exitosa.');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()
            ->route('productos.index')
            ->with('success-destroy', 'Mercadería eliminada con éxito.');
    }

    public function filter(Request $request)
    {
        $products = [];
        $categories = Category::all();

        if ($request->input('description') && $request->input('category')) {
            $products = Product::has('categories', '=', $request->input('category'))
                ->where('description', 'like', '%' . $request->input('description') . '%')
                ->get();
        } else {
            $products = Product::has('categories', '=', $request->input('category'))->get();
        }

        return view('productos.filter', compact(['products', 'categories']));
    }
}
