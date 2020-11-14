<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleOrder as RequestsSaleOrder;
use App\Models\Category;
use App\Models\Product;
use App\Models\SaleOrder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SaleOrderController extends Controller
{

    /**
     * VERIFICAR PAGINA 'CREATE', LOS CAMPOS DINAMICOS DEL FORM DE PRODUCTOS
     * AL TENER UN ERROR, SE "ROMPE"
     * - CREAR UN INPUT DEMAS
     * - NO DEJA QUITAR LOS ANTERIORES, SOLO APARECE EL ICONO DE '+'
     * 
     *  BORRADO LOGICO EN CATEGORIAS, PRODUCTOS
     * 
     * - AGREGAR LOGICA EN CUIT EN CONTROLLER ORDERSALE, NUEVO CAMPO AGREGADO EN FORM CREATE
     */

    public function index()
    {
        $orders = SaleOrder::all();
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
                    'quantity_tags' => $request->input('productTags')[$i]
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return redirect()->route('create.index');
        }

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
