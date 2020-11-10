<?php

namespace App\Http\Controllers;

use App\Models\SaleOrder;
use Illuminate\Http\Request;

class SaleOrderController extends Controller
{

    public function index()
    {
        $orders = SaleOrder::all();
        return view('orden-ventas.index', compact('orders'));
    }

    public function create()
    {
        return view('orden-ventas.create');
    }

    public function store(Request $request)
    {

        /**
         * Check object
         * Save SaleOrder object
         * Save each product in db
         * Redirect to index page
         */

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
        return redirect()->route('orden-ventas.index', ['success' => true]);
    }

    public function show($id)
    {
        $order = SaleOrder::find($id);
        return view('orden-ventas.show', compact('order'));
    }

    public function filter($id)
    {
        dd($id);
        // return view('orden-ventas.');
    }

    public function pdf(SaleOrder $order)
    {
        dd($order);
        // return view('orden-ventas.');
    }
}
