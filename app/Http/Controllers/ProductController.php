<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::orderBy('id', 'desc')->paginate('10');
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

        if ($request->has('type_search')) {
            if ($request->input('type_search') == 'code') {
                $products = Product::where('id', $request->input('search'))->get();
            } else if ($request->input('type_search') == 'description') {
                if ($request->input('search') !== null) {
                    $products = Product::where('description', 'LIKE', '%' .  $request->input('search') . '%')->get();
                }
            } else if ($request->input('type_search') == 'category') {
                $cat = Category::where('id', $request->input('category'))->first();
                $products = $cat->products;
            } else if ($request->input('type_search') == 'comprador') {
                if ($request->input('name') !== null || $request->input('lastname') !== null) {
                    if ($request->input('name') !== null xor $request->input('lastname') !== null) {
                        if ($request->input('name') !== null && $request->input('lastname') == null) {
                            $products = Product::whereHas('invoices.user', function (Builder $query) use ($request) {
                                $query
                                    ->where('name', 'like', $request->input('name') . '%')
                                    ->where('type_invoice', 'cliente');
                            })->get();
                        } elseif ($request->input('name') == null && $request->input('lastname') !== null) {
                            $products = Product::whereHas('invoices.user', function (Builder $query) use ($request) {
                                $query
                                    ->where('lastname', 'like', $request->input('name') . '%')
                                    ->where('type_invoice', 'cliente');
                            })->get();
                        }
                    } elseif ($request->input('name') && $request->input('lastname')) {
                        $products = Product::whereHas('invoices.user', function (Builder $query) use ($request) {
                            $query
                                ->where('name', 'like', $request->input('name') . '%')
                                ->where('lastname', 'like', $request->input('lastname') . '%')
                                ->where('type_invoice', 'cliente');
                        })->get();
                    }
                }
            } else if ($request->input('type_search') == 'remitente') {
                if ($request->input('name') !== null || $request->input('lastname') !== null) {
                    if ($request->input('name') !== null xor $request->input('lastname') !== null) {
                        if ($request->input('name') !== null && $request->input('lastname') == null) {
                            $products = Product::whereHas('invoices.user', function (Builder $query) use ($request) {
                                $query
                                    ->where('name', 'like', $request->input('name') . '%')
                                    ->where('type_invoice', 'remitente');
                            })->get();
                        } elseif ($request->input('name') == null && $request->input('lastname') !== null) {
                            $products = Product::whereHas('invoices.user', function (Builder $query) use ($request) {
                                $query
                                    ->where('lastname', 'like', $request->input('name') . '%')
                                    ->where('type_invoice', 'remitente');
                            })->get();
                        }
                    } elseif ($request->input('name') && $request->input('lastname')) {
                        $products = Product::whereHas('invoices.user', function (Builder $query) use ($request) {
                            $query
                                ->where('name', 'like', $request->input('name') . '%')
                                ->where('lastname', 'like', $request->input('lastname') . '%')
                                ->where('type_invoice', 'remitente');
                        })->get();
                    }
                }
            }
        } elseif ($request->has('q')) {
            $query = $request->input('q');
            if ($query == 'vendidas') {
                $products = Product::whereHas('invoices.user')->orderBy('id', 'desc')->paginate('10');
            } else if ($query == 'no-vendidas') {
                $products = Product::doesntHave('invoices.user')->orderBy('id', 'desc')->paginate('10');
            }
            return view('productos.filter2', compact(['query', 'products']));
        }

        return view('productos.filter', compact(['products', 'categories']));
    }
}
