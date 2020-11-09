<?php

namespace App\Http\Controllers;

use App\Models\SaleOrder;
use Illuminate\Http\Request;

class SaleOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = SaleOrder::all();
        return view('orden-ventas.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('orden-ventas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        /**
         * Check object
         * Save SaleOrder object
         * Save each product in db
         * Redirect to index page
         */

        $order = new SaleOrder();
        // $order->

        // $order = SaleOrder::create([
        //     'date_set' => '1',
        //     'remito' => '1',
        //     'order_number' => '1',
        //     'user_id' => '1'
        // ]);

        // $order->products()->createMany([
        //     [
        //         'quantity' => 1,
        //         'quantity_tags' => 1,
        //     ],
        //     [
        //         'quantity_tags' => 1,
        //     ],
        // ]);

        // $order->save();

        dd($request->all());
        // return redirect()->route('orden-ventas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $order = SaleOrder::
        return view('orden-ventas.show', compact('order'));
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

    public function filter()
    {
        // return view('orden-ventas.');
    }
}
