<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Añadir un objeto de tipo User Request para validar los campos de los formularios
 */
class UserController extends Controller
{

    public function index()
    {
        $users = User::paginate('10');
        return view('usuarios.index', compact('users'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $password = $request->input('password');
        $password = Hash::make('secret');
        $user = User::create([
            'name' => $request->input('name'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'password' => $password,
            'address' => $request->input('address'),
            'postal_code' => $request->input('postal_code'),
            'city' => $request->input('city'),
            'phone' => $request->input('phone'),
            'dni' => $request->input('dni'),
            'cuit' => $request->input('cuit')
        ]);

        if ($request->input('customer-role') != null) {
            $user_role = $user->roles()->attach($request->input('customer-role'));
        }
        if ($request->input('provider-role') != null) {
            $user_role = $user->roles()->attach($request->input('provider-role'));
        }
        if ($request->input('admin-role') != null) {
            $user_role = $user->roles()->attach($request->input('admin-role'));
        }

        return redirect()
            ->route('usuarios.index')
            ->with('success-store', 'El usuario ha sido creada de manera exitosa.');
    }

    public function search()
    {
        //$user = User::where();
    }

    public function filter()
    {
        return view('usuarios.filter');
    }

    public function show()
    {

        $users = null;
        if (!empty($_POST)) {
            if ($_POST['type_search'] != null) {
                if ($_POST['type_search'] == 'name') {
                    if (($_POST['name'] != null) xor ($_POST['lastname'] != null)) {
                        $users = User::where('name', $_POST['name'])
                            ->orWhere('lastname', $_POST['lastname'])
                            ->get();
                    } elseif (($_POST['name'] != null) && ($_POST['lastname'] != null)) {

                        $users = User::where('name', $_POST['name'])
                            ->where('lastname', $_POST['lastname'])
                            ->get();
                    }
                } else if ($_POST['type_search'] == 'dni') {
                    $users = User::where('dni', $_POST['search'])->get();
                } else if ($_POST['type_search'] == 'cuit') {
                    $users = User::where('cuit', $_POST['search'])->get();
                }
            }
        }
        if (empty($users[0])) {
            $users = null;
        }

        return view('usuarios.show', compact('users'));
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->get();
        $check_customer = false;
        $check_provider = false;
        $check_admin = false;
        foreach ($user[0]->roles as $role) {
            if ($role->id == 3) {
                $check_customer = true;
            }
            if ($role->id == 2) {
                $check_provider = true;
            }
            if ($role->id == 1) {
                $check_admin = true;
            }
        }

        return view('usuarios.edit', compact('user', 'check_customer', 'check_provider', 'check_admin', 'id'));
    }

    public function update(Request $request, $id)
    {
        $error = null;
        if ($request->input('password') != $request->input('password-repeat')) {
            $error = "Las contraseñas ingresadas no son iguales";
        }
        if ($error != null) {
            $user = User::where('id', $id)
                ->update(
                    ['name' => $request->input('name')],
                    ['lastname' => $request->input('lastname')],
                    ['email' => $request->input('email ')],
                    ['phone' => $request->input('phone')],
                    ['city' => $request->input('city')],
                    ['postal_code' => $request->input('postal_code')],
                    ['address' => $request->input('address')],
                    ['dni' => $request->input('dni')],
                    ['cuit' => $request->input('cuit')]

                );
        }

        return $this->edit($id);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()
            ->route('usuarios.index')
            ->with('success-destroy', 'Usuario eliminado con éxito.');
    }

    public function getAutocompleteData(Request $request)
    {
        if ($request->has('term')) {
            return User::where('name', 'like', '%' . $request->input('term') . '%')->get();
        }
    }
}
