<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceProforma as RequestsInvoiceProforma;
use App\Models\InvoiceProforma;
use App\Models\Product;
use App\Models\User;
use App\Models\SaleOrder;
use Illuminate\Http\Request;

use PDF;

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
        $order = SaleOrder::find($request->input('orden'));
        $product = Product::find($request->input('mercaderia'));

        if ($order === null || $product === null) {
            return redirect()
                ->route('proformas.pre-create')
                ->with('error-store', 'Error inesperado! Ha ocurrido un error en la base de datos. Si el error persiste, consulte con los desarrolladores.');
        }

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

    public function filter(Request $request)
    {
        $invoices = [];
        $from = null;
        $to = null;

        if ($request->input('date_start') && $request->input('date_end')) {

            $from = date($request->input('date_start'));
            $to = date($request->input('date_end'));

            $invoices = InvoiceProforma::whereBetween('date_remate', [$from, $to])->get();
        }

        return view('proformas.filter', compact(['invoices', 'from', 'to']));
    }

    public function pdf($id)
    {
        $invoice = InvoiceProforma::find($id);
        $title = 'proforma-' . $id . '.pdf';
        $pdf = PDF::loadView('proformas.pdf', compact('invoice'));
        return $pdf->stream($title);
    }
}
