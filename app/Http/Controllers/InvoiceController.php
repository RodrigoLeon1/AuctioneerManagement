<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\InvoiceProforma;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!empty($_POST)) {
            if ($_POST['type_search'] != null) {

                if ($_POST['type_search'] == 'dni') {
                    $user = User::where('dni', $_POST['search'])->first();
                } else if ($_POST['type_search'] == 'cuit') {
                    $user = User::where('cuit', $_POST['search'])->first();
                } else if ($_POST['type_search'] == 'id') {
                    $user = User::where('id', $_POST['search'])->first();
                }
            }
        }


        if ($user != null) {
            $products = array();
            $isTypeUser = 0;
            $role = $_POST['user'];
            foreach ($user->roles as $role) {
                if ($role->id == $_POST['user']) {
                    $isTypeUser = 1;
                }
            }
            if ($isTypeUser == 0) {
                $user->roles()->attach($_POST['user']);
            }

            /*$proformas = InvoiceProforma::where('user_id', $user->id)->get();
            foreach($proformas as $proforma){
                $product = Product::where('id', $proforma->product_id)->get();
                array_push($products, $product);
            }*/

            $product1 = new Product();
            $product1->description = "Mesa";
            $product1->id = 1;

            $product2 = new Product();
            $product2->description = "Silla";
            $product2->id = 2;

            $product3 = new Product();
            $product3->description = "Ropero";
            $product3->id = 3;

            $product4 = new Product();
            $product4->description = "Sillon";
            $product4->id = 4;

            $product5 = new Product();
            $product5->description = "Ventilador";
            $product5->id = 5;

            array_push($products, $product1);
            array_push($products, $product2);
            array_push($products, $product3);
            array_push($products, $product4);
            array_push($products, $product5);
        }



        return view('liquidaciones.create', compact('user', 'products', 'role'));
    }

    public function filter($user)
    {
        return view('liquidaciones.filter', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
