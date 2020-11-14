<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category as RequestsCategory;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return view('categorias.index', compact('categories'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(RequestsCategory $request)
    {
        Category::create([
            'description' => $request->input('description')
        ]);

        return redirect()->route('categorias.index', ['success' => true]);
    }

    public function show($id)
    {
        $category = Category::find($id);
        return view('categorias.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
