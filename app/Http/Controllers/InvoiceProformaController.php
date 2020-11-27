<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceProforma as RequestsInvoiceProforma;
use App\Models\InvoiceProforma;
use App\Models\Product;
use App\Models\User;
use App\Models\SaleOrder;
use Illuminate\Http\Request;

class InvoiceProformaController extends Controller
{

    public function index()
    {
        $invoices = InvoiceProforma::all();
        return view('proformas.index', compact('invoices'));
    }

    public function preCreate()
    {
        $orders = SaleOrder::all();
        return view('proformas.pre-create', compact('orders'));
    }

    public function create(Request $request)
    {
        if (!$request->has('orden') || !$request->has('mercaderia')) {
            dd('error');
        }

        $order = SaleOrder::find($request->input('orden'));
        $product = Product::find($request->input('mercaderia'));

        return view('proformas.create', compact(['order', 'product']));
    }

    public function store(RequestsInvoiceProforma $request)
    {

        $user = User::find($request->input('id-user'));

        // Refactor...
        if ($user === null) {
            $user = User::create([
                'name' => $request->input('name-order'),
                'lastname' => $request->input('lastname-order'),
                'address' => $request->input('address-order'),
                'phone' => $request->input('phone-order'),
                'postal_code' => $request->input('cp-order'),
                'city' => $request->input('city-order'),
                'dni' => $request->input('dni-order'),
                'cuit' => $request->input('cuit-order'),
            ]);
        }

        InvoiceProforma::create([
            'date_remate' => $request->input('date_remate'),
            'date_delivery' => $request->input('date_remate_delivery'),
            'quantity' => $request->input('quantity'),
            'price_unit' => $request->input('price_unit'),
            'partial_total' => $request->input('partial_total'),
            'commission' => $request->input('commission'),
            'partial_payment' => $request->input('partial_payment'),
            'total' => $request->input('total'),
            'user_id' => $user->id,
            'sale_order_id' => $request->input('order_id'),
            'product_id' => $request->input('product_id')
        ]);

        return redirect()
            ->route('proformas.index')
            ->with('success-store', 'Su proforma ha sido creada de manera exitosa.');
    }

    public function show($id)
    {
        $invoice = InvoiceProforma::find($id);
        return view('proformas.show', compact('invoice'));
    }

    public function pdf($id)
    {
    }
}
