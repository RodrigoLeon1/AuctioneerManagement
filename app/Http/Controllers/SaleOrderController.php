<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SaleOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PDF;

class SaleOrderController extends Controller
{

    public function index()
    {
        $orders = SaleOrder::orderBy('id', 'desc')->paginate('10');
        return view('orden-ventas.index', compact('orders'));
    }

    public function create()
    {
        $categories = Category::all();
        $lastOrder = (SaleOrder::latest()->first() !== null) ? SaleOrder::latest()->first()->id : 0;
        return view('orden-ventas.create', compact('categories', 'lastOrder'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $user = User::find($request->input('id-user'));
        $this->validateSaleOrder($request, $user);

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

            $order = SaleOrder::create([
                'date_set' => $request->input('date_set'),
                'date_payment' => $request->input('date_payment'),
                'remito' => $request->input('remito'),
                'order_number' => $request->input('order_number'),
                'user_id' => $user->id
            ]);

            // Create and save each product of sale order
            for ($i = 0; $i < sizeof($request->input('productDescription')); $i++) {
                if ($request->input('productDescription')[$i] != null) {
                    $product = Product::create([
                        'description' => $request->input('productDescription')[$i]
                    ]);

                    $product->categories()->attach($request->input('productCategory')[$i]);

                    $order->products()->attach($order->id, [
                        'product_id' => $product->id,
                        'quantity' => $request->input('productQuantity')[$i],
                        'quantity_sold' => 0,
                        'quantity_remaining' => $request->input('productQuantity')[$i],
                        'quantity_tags' => $request->input('productTags')[$i],
                        'tasac' => $request->input('productTasac')[$i],
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->route('orden-ventas.create')
                ->with('error-store', 'Error inesperado! Ha ocurrido un error en la base de datos. Si el error persiste, consulte con los desarrolladores.');
        }

        return redirect()
            ->route('orden-ventas.index')
            ->with('success-store', 'Su orden de venta ha sido creada de manera exitosa.');
    }

    private function validateSaleOrder(Request $request, $user)
    {
        if ($user) {
            $request->validate([
                'date_set' => 'required|date|after_or_equal:start_date',
                'date_payment' => 'required|date|after_or_equal:start_date',
                'remito' => 'required|integer',
                'order_number' => 'required|integer|unique:sale_orders,order_number',
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
                'date_set' => 'required|date|after_or_equal:start_date',
                'date_payment' => 'required|date|after_or_equal:start_date',
                'remito' => 'required|integer',
                'order_number' => 'required|integer|unique:sale_orders,order_number',
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
        $order = SaleOrder::find($id);
        return view('orden-ventas.show', compact('order'));
    }

    public function filter(Request $request)
    {
        $orders = [];
        $from = null;
        $to = null;

        if ($request->input('date_start') && $request->input('date_end')) {

            $from = date($request->input('date_start'));
            $to = date($request->input('date_end'));

            $orders = SaleOrder::whereBetween('date_set', [$from, $to])->get();
        }

        return view('orden-ventas.filter', compact(['orders', 'from', 'to']));
    }

    public function pdf($id)
    {
        $order = SaleOrder::find($id);
        $title = 'orden-venta-' . $id . '.pdf';
        $pdf = PDF::loadView('orden-ventas.pdf', compact('order'));
        return $pdf->stream($title);
    }

    public function tags($id)
    {
        $order = SaleOrder::find($id);
        $title = 'Etiquetas';
        $pdf = PDF::loadView('orden-ventas.tags', compact('order'));
        return $pdf->stream($title);
    }
}
