<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceProforma;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;

use PDF;

class InvoiceController extends Controller
{

    public function index()
    {
        $invoices = Invoice::paginate('10');
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

        // Get user role, 'cliente' or 'remitente'
        $role = null;

        $proformas = InvoiceProforma::where('user_id', $user->id)->get();

        return view('liquidaciones.create', compact('user', 'role', 'proformas'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $user = User::find($request->input('user-id'));

            if ($user == null) {
                throw new Exception();
            }

            // Get user role, 'cliente' or 'remitente'... fix
            if ($request->input('user-role') == 3) {
                $role = 'cliente';
                $commission = 20;
            } else {
                $role = 'remitente';
                $commission = 10;
            }

            $invoice = Invoice::create([
                'type_invoice' => $role,
                'partial_payment' => 0,
                'commission' => 0,
                'total' => 0,
                'user_id' => $user->id
            ]);

            // Create and save each product of the invoice
            for ($i = 0; $i < sizeof($request->input('productsIds')); $i++) {

                $product = Product::findOrFail($request->input('productsIds')[$i]);
                $invoice->products()->attach($invoice->id, [
                    'quantity' => 1,
                    'price_unit' => 2,
                    'total' => 3,
                    'product_id' => $product->id,
                    'invoice_id' => $invoice->id
                ]);

                // Update the product's attribute 'is invoiced' so it can't be added again...

            }

            DB::commit();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return redirect()
                ->route('liquidaciones.create')
                ->with('error-store', 'Error inesperado! Ha ocurrido un error en la base de datos. Si el error persiste, consulte con los desarrolladores.');
        }

        return redirect()
            ->route('liquidaciones.filter')
            ->with('success-index', 'Su orden de venta ha sido creada de manera exitosa.');
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
        $pdf = PDF::loadView('liquidacion.pdf', compact('invoice'));
        return $pdf->stream($title);
    }
}
