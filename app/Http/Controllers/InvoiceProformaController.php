<?php

namespace App\Http\Controllers;

use App\Models\InvoiceProforma;
use App\Models\Product;
use App\Models\User;
use App\Models\SaleOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PDF;

class InvoiceProformaController extends Controller
{

    public function index()
    {
        $invoices = InvoiceProforma::orderBy('id', 'desc')->paginate('10');
        return view('proformas.index', compact('invoices'));
    }

    public function preCreate()
    {
        $orders = SaleOrder::orderBy('id', 'desc')->paginate(5);
        return view('proformas.pre-create', compact('orders'));
    }

    public function create(Request $request)
    {

        if ($request->input('product-code') != null) {

            $product = Product::find($request->input('product-code'));
            if ($product === null) {
                return redirect()
                    ->route('proformas.pre-create')
                    ->with('error-store', 'El código ingresado no se encuentra asociado a ningún producto, probablemente el código es erróneo. Vuelva a intentar.');
            }

            $order = $product->saleorder();

            if ($product->saleorder[0]->pivot->quantity_remaining == 0 || $order === null) {
                return redirect()
                    ->route('proformas.pre-create')
                    ->with('error-store', 'La mercadería no posee más unidades para vender. Vuelva a intentar.');
            }
        } else {
            $order = SaleOrder::find($request->input('orden'));
            $product = Product::find($request->input('mercaderia'));

            if ($order === null || $product === null) {
                return redirect()
                    ->route('proformas.pre-create')
                    ->with('error-store', 'Error inesperado! Ha ocurrido un error en la base de datos. Si el error persiste, consulte con los desarrolladores.');
            }

            if ($product->saleorder[0]->pivot->quantity_remaining == 0) {
                return redirect()->route('proformas.pre-create');
            }
        }

        return view('proformas.create', compact(['order', 'product']));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $user = User::find($request->input('id-user'));
        $this->validateInvoiceProforma($request, $user);

        try {

            // Refactor...
            if ($user === null) {
                $user = User::create([
                    'name' => $request->input('name'),
                    'lastname' => $request->input('lastname'),
                    'address' => $request->input('address'),
                    'phone' => $request->input('phone'),
                    'postal_code' => $request->input('postal_code'),
                    'city' => $request->input('city'),
                    'dni' => $request->input('dni'),
                    'cuit' => $request->input('cuit'),
                ]);
            }

            InvoiceProforma::create([
                'date_remate' => $request->input('date_remate'),
                'date_delivery' => $request->input('date_delivery'),
                'quantity' => $request->input('quantity'),
                'price_unit' => $request->input('price_unit'),
                'partial_total' => $request->input('partial_total'),
                'partial_payment' => $request->input('partial_payment'),
                'total' => $request->input('total'),
                'user_id' => $user->id,
                'sale_order_id' => $request->input('order_id'),
                'product_id' => $request->input('product_id')
            ]);

            $product = Product::findOrFail($request->input('product_id'));

            DB::table('product_sale_order')
                ->where('sale_order_id', $request->input('order_id'))
                ->where('product_id', $request->input('product_id'))
                ->update([
                    'quantity_sold' => $product->saleorder[0]->pivot->quantity_sold + $request->input('quantity'),
                    'quantity_remaining' => $product->saleorder[0]->pivot->quantity_remaining - $request->input('quantity')
                ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->route('proformas.create')
                ->with('error-store', 'Error inesperado! Ha ocurrido un error en la base de datos. Si el error persiste, consulte con los desarrolladores.');
        }

        return redirect()
            ->route('proformas.index')
            ->with('success-store', 'Su proforma ha sido creada de manera exitosa.');
    }

    private function validateInvoiceProforma(Request $request, $user)
    {
        if ($user) {
            $request->validate([
                'date_remate' => 'required|date|after_or_equal:start_date',
                'date_delivery' => 'required|date|after_or_equal:start_date',
                'quantity' => 'required|numeric',
                'price_unit' => 'required|numeric',
                'partial_total' => 'required|numeric',
                'partial_payment' => 'required|numeric',
                'total' => 'required|numeric',
                'name' => 'required|string',
                'lastname' => 'required|string',
                'email' => 'nullable|email|unique:users,email,' . $user->id,
                'address' => 'nullable|string',
                'postal_code' => 'nullable|string',
                'city' => 'nullable|string',
                'phone' => 'nullable|string|unique:users,phone,' . $user->id,
                'dni' => 'nullable|string|unique:users,dni,' . $user->id,
                'cuit' => 'nullable|string|unique:users,cuit,' . $user->id,
            ]);
        } else {
            $request->validate([
                'date_remate' => 'required|date|after_or_equal:start_date',
                'date_delivery' => 'required|date|after_or_equal:start_date',
                'quantity' => 'required|numeric',
                'price_unit' => 'required|numeric',
                'partial_total' => 'required|numeric',
                'partial_payment' => 'required|numeric',
                'total' => 'required|numeric',
                'name' => 'required|string',
                'lastname' => 'required|string',
                'email' => 'nullable|email|unique:users,email',
                'address' => 'nullable|string',
                'postal_code' => 'nullable|string',
                'city' => 'nullable|string',
                'phone' => 'nullable|string|unique:users,phone',
                'dni' => 'nullable|string|unique:users,dni',
                'cuit' => 'nullable|string|unique:users,cuit'
            ]);
        }
    }

    public function show($id)
    {
        $invoice = InvoiceProforma::find($id);
        return view('proformas.show', compact('invoice'));
    }

    public function destroy($id)
    {
        try {

            $invoice = InvoiceProforma::find($id);

            // Update quantities on product_sale_order once the object is deleted
            $product = Product::find($invoice->product_id);

            DB::table('product_sale_order')
                ->where('sale_order_id', $invoice->sale_order_id)
                ->where('product_id', $invoice->product_id)
                ->update([
                    'quantity_sold' => $product->saleorder[0]->pivot->quantity_sold - $invoice->quantity,
                    'quantity_remaining' => $product->saleorder[0]->pivot->quantity_remaining + $invoice->quantity
                ]);

            $invoice->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->route('proformas.index')
                ->with('error-store', 'Error inesperado! Ha ocurrido un error en la base de datos. Si el error persiste, consulte con los desarrolladores.');
        }

        return redirect()
            ->route('proformas.index')
            ->with('success-destroy', 'Proforma eliminada con éxito.');
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
        } else if ($request->input('date_start')) {
            $from = date($request->input('date_start'));
            $invoices = InvoiceProforma::where('date_remate', $from)->get();
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
