<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceProforma;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

use PDF;

class InvoiceController extends Controller
{

    public function index()
    {
        $invoices = Invoice::orderBy('id', 'desc')->paginate('10');
        return view('liquidaciones.index', compact('invoices'));
    }

    public function preCreate()
    {
        return view('liquidaciones.pre-create');
    }

    public function create(Request $request)
    {
        if (!$request->input('type_search') || !$request->input('search')) {
            return redirect()->back();
        }

        if ($_GET['type_search'] == 'dni') {
            $user = User::where('dni', $_GET['search'])->first();
        } else if ($_GET['type_search'] == 'cuit') {
            $user = User::where('cuit', $_GET['search'])->first();
        }

        if ($user == null) {
            return redirect()
                ->back()
                ->with('error-search', 'El DNI/CUIT ingresado no se encuentra asociado a un usuario. Vuelva a intentar.');
        }

        $proformas = InvoiceProforma::where('user_id', $user->id)
            ->where('is_invoiced', false)
            ->get();

        if (sizeof($proformas) == 0) {
            return redirect()
                ->back()
                ->with('error-search', 'El usuario no tiene proformas asociadas para poder crear la liquidación correspondiente.');
        }

        return view('liquidaciones.create', compact('user', 'proformas'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $user = User::findOrFail($request->input('user_id'));
            $commissionPercentage = $request->input('commission_percentage') ? $request->input('commission_percentage') : 0;
            $partialPayment = $request->input('partial_payment');
            $subtotal = 0;
            $priceTotal = 0;

            // Create the invoice
            $invoice = Invoice::create([
                'type_invoice' => 'cliente',
                'user_id' => $user->id
            ]);

            // Create and save each product of the invoice
            for ($i = 0; $i < sizeof($request->input('productsIds')); $i++) {

                $proforma = InvoiceProforma::findOrFail($request->input('proformasIds')[$i]);
                $product = Product::findOrFail($request->input('productsIds')[$i]);
                $productQuantity = $request->input('productsQuantities')[$i];
                $subtotal += ($productQuantity * $proforma->price_unit);

                $invoice->products()->attach($invoice->id, [
                    'quantity' => $productQuantity,
                    'price_unit' => $proforma->price_unit,
                    'total' => $productQuantity * $proforma->price_unit,
                    'product_id' => $product->id,
                    'invoice_id' => $invoice->id
                ]);

                // Update the proforma's attribute 'is invoiced' so it can't be added again...                
                DB::table('invoice_proformas')
                    ->where('id', $proforma->id)
                    ->update([
                        'is_invoiced' => true
                    ]);

                $priceTotal += $proforma->partial_total;
            }

            $commission = ($priceTotal * ($commissionPercentage / 100));

            Invoice::where('id', $invoice->id)
                ->update([
                    'commission' => $commission,
                    'commission_percentage' => $commissionPercentage,
                    'partial_payment' => $partialPayment,
                    'subtotal' => $subtotal,
                    'total' => $priceTotal + $commission - $partialPayment
                ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->route('liquidaciones.create')
                ->with('error-store', 'Error inesperado! Ha ocurrido un error en la base de datos. Si el error persiste, consulte con los desarrolladores.');
        }

        return redirect()
            ->route('liquidaciones.pre-create')
            ->with('success-store', 'Su liquidación ha sido creada de manera exitosa.');
    }

    public function show($id)
    {
        $invoice = Invoice::find($id);
        return view('liquidaciones.show', compact('invoice'));
    }

    public function pdf($id)
    {
        $invoice = Invoice::find($id);
        $title = 'liquidacion-' . $id . '.pdf';
        $pdf = PDF::loadView('liquidaciones.pdf', compact('invoice'));
        return $pdf->stream($title);
    }
}
