<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceProforma;
use App\Models\SaleOrder;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

use PDF;

class InvoiceController extends Controller
{

    public function index()
    {
        $invoices = Invoice::orderBy('id', 'desc')->paginate('10');
        return view('liquidaciones.index', compact('invoices'));
    }

    public function preCreate(Request $request)
    {
        $tu = $request->input('tu');
        return view('liquidaciones.pre-create', compact('tu'));
    }

    public function create(Request $request)
    {
        if ($request->input('user_id') != null) {
            $user = User::where('id', $request->input('user_id'))->first();
        } else {

            if (!$request->input('type_search')) {
                return redirect()->back();
            }

            if ($request->has('type_search')) {
                if ($request->input('type_search') == 'name') {
                    if ($request->input('name') !== null xor $request->input('lastname') !== null) {
                        $user = User::where('name', $request->input('name'))
                            ->orWhere('lastname', $request->input('lastname'))
                            ->get();
                    } elseif ($request->input('name') && $request->input('lastname')) {
                        $user = User::where('name', $request->input('name'))
                            ->where('lastname', $request->input('lastname'))
                            ->first();
                    }
                } else if ($request->input('type_search') == 'dni') {
                    $user = User::where('dni', $request->input('search'))->first();
                } else if ($request->input('type_search') == 'cuit') {
                    $user = User::where('cuit', $request->input('search'))->first();
                }
            }
            if ($user != null) {
                if (get_class($user) != "App\Models\User") {
                    return redirect()
                        ->back()                        
                        ->with(['user' => $user], ['tu' => $request->input('tu')]);
                }
            }
        }

        if ($user == null) {
            if ($request->input('type_search') == 'dni' || $request->input('type_search') == 'cuit') {
                return redirect()
                    ->back()
                    ->with('error-search', 'El DNI/CUIT ingresado no se encuentra asociado a un usuario. Vuelva a intentar.');
            }
            return redirect()
                ->back()
                ->with('error-search', 'No se han encontrado liquidaciones para el nombre de usuario ingresado.');
        }

        if ($request->input('tu') == 'cliente') {
            $proformas = InvoiceProforma::where('user_id', $user->id)
                ->where('is_invoiced', false)
                ->get();
        } else {

            $so = SaleOrder::where('user_id', $user->id)->get();            
            $proformas = [];

            foreach ($so as $s) {
                $proformasAux = InvoiceProforma::where('sale_order_id', $s->id)
                    ->where('is_invoiced', true)
                    ->where('is_invoiced_remitente', false)
                    ->get();

                foreach ($proformasAux as $proforma) {
                    array_push(
                        $proformas,
                        $proforma
                    );
                }
            }

            if (sizeof($proformas) == 0) {
                return redirect()
                    ->back()
                    ->with('error-search', 'El usuario no tiene proformas asociadas para poder crear la liquidación correspondiente.');
            }

            $tu = $request->input('tu');            
            return view('liquidaciones.create', compact('user', 'proformas', 'tu'));
        }        

        if (sizeof($proformas) == 0) {
            return redirect()
                ->back()
                ->with('error-search', 'El usuario no tiene proformas asociadas para poder crear la liquidación correspondiente.');
        }

        $tu = $request->input('tu');
        return view('liquidaciones.create', compact('user', 'proformas', 'tu'));
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
            
            if ($request->input('tu') == 'remitente') {
                $isRemitente = true;
            } else {
                $isRemitente = false;
            }           

            // Create the invoice
            $invoice = Invoice::create([
                'type_invoice' => $request->input('tu'),
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
                        'is_invoiced' => true,
                        'is_invoiced_remitente' => $isRemitente
                    ]);

                $priceTotal += $proforma->partial_total;
            }

            $commission = ($priceTotal * ($commissionPercentage / 100));
            if ($request->input('tu') == 'cliente') {
                $finalPrice = $priceTotal + $commission - $partialPayment;
            } else {
                $finalPrice = $priceTotal - $commission - $partialPayment;
            }

            Invoice::where('id', $invoice->id)
                ->update([
                    'commission' => $commission,
                    'commission_percentage' => $commissionPercentage,
                    'partial_payment' => $partialPayment,
                    'subtotal' => $subtotal,
                    'total' => $finalPrice
                ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->route('liquidaciones.create')
                ->with('error-store', 'Error inesperado! Ha ocurrido un error en la base de datos. Si el error persiste, consulte con los desarrolladores.');
        }

        return redirect()
            ->route('liquidaciones.pre-create', ['tu' => $request->input('tu')])
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

    public function filter(Request $request)
    {
        $invoices = [];

        if ($request->has('type_search')) {

            if ($request->input('type_search') == 'name') {
                if ($request->input('name') !== null xor $request->input('lastname') !== null) {
                    if ($request->input('name') !== null && $request->input('lastname') == null) {
                        $invoices = Invoice::whereHas('user', function (Builder $query) use ($request) {
                            $query->where('name', 'like', $request->input('name') . '%');
                        })->get();
                    } elseif ($request->input('name') == null && $request->input('lastname') !== null) {
                        $invoices = Invoice::whereHas('user', function (Builder $query) use ($request) {
                            $query->where('lastname', 'like', $request->input('lastname') . '%');
                        })->get();
                    }
                } elseif ($request->input('name') && $request->input('lastname')) {
                    $invoices = Invoice::whereHas('user', function (Builder $query) use ($request) {
                        $query
                            ->where('name', 'like', $request->input('name') . '%')
                            ->where('lastname', 'like', $request->input('lastname') . '%');
                    })->get();
                }
            } else if ($request->input('type_search') == 'dni') {
                $invoices = Invoice::whereHas('user', function (Builder $query) use ($request) {
                    $query->where('dni', 'like', $request->input('search') . '%');
                })->get();
            } else if ($request->input('type_search') == 'cuit') {
                $invoices = Invoice::whereHas('user', function (Builder $query) use ($request) {
                    $query->where('cuit', 'like', $request->input('search') . '%');
                })->get();
            }
        }

        return view('liquidaciones.filter', compact('invoices'));
    }
}
