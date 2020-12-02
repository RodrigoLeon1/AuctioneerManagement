<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleOrder as RequestsSaleOrder;
use App\Models\Category;
use App\Models\Product;
use App\Models\SaleOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PDF;

class SaleOrderController extends Controller
{

    /**               
     *  - Corregir inputs de mercaderia dinamicos en el SaleOrder 
     *    (Al haber un error, no deja quitar los anteriores, crear un input de mas (?) )
     * 
     *  - Estilos PDF Orden de venta, proforma, liquidaciones     
     */

    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $orders = SaleOrder::paginate('10');
        return view('orden-ventas.index', compact('orders'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('orden-ventas.create', compact('categories'));
    }

    public function store(RequestsSaleOrder $request)
    {
        DB::beginTransaction();

        try {

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

            $order = SaleOrder::create([
                'date_set' => $request->input('date_set'),
                'date_payment' => $request->input('date_payment'),
                'remito' => $request->input('remito'),
                'order_number' => $request->input('order_number'),
                'user_id' => $user->id
            ]);

            // Create and save each product of sale order
            for ($i = 0; $i < sizeof($request->input('productDescription')); $i++) {

                $product = Product::create([
                    'description' => $request->input('productDescription')[$i]
                ]);

                $product->categories()->attach($request->input('productCategory')[$i]);

                $order->products()->attach($order->id, [
                    'product_id' => $product->id,
                    'quantity' => $request->input('productQuantity')[$i],
                    'quantity_sold' => 0,
                    'quantity_remaining' => $request->input('productQuantity')[$i],
                    'quantity_tags' => $request->input('productTags')[$i]
                ]);
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
}
