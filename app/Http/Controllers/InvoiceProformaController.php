<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceProformaRequest;
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
        $invoices = InvoiceProforma::all();
        return view('proformas.index', compact('invoices'));
    }

    public function preCreate()
    {
        $orders = SaleOrder::paginate(5);
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

        if ($product->saleorder[0]->pivot->quantity_remaining == 0) {
            return redirect()->route('proformas.pre-create');
        }

        return view('proformas.create', compact(['order', 'product']));
    }

    public function store(StoreInvoiceProformaRequest $request)
    {
        DB::beginTransaction();

        try {

            $user = User::findOrFail($request->input('id-user'));

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
                'commission_percentage' => $request->input('commission_percentage'),
                'commission_value' => $request->input('commission_value'),
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
