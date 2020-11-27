<?php

namespace App\Http\Controllers;

use App\Http\Requests\User as RequestsUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function store(RequestsUser $request)
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

    public function show($id)
    {
        $user = User::find($id);
        return view('usuarios.show', compact('user'));
    }

    public function filter(Request $request)
    {
        $users = [];

        if ($request->has('type_search')) {
            if ($request->input('type_search') == 'name') {
                if ($request->input('name') !== null xor $request->input('lastname') !== null) {
                    $users = User::where('name', $request->input('name'))
                        ->orWhere('lastname', $request->input('lastname'))
                        ->get();
                } elseif ($request->input('name') && $request->input('lastname')) {
                    $users = User::where('name', $request->input('name'))
                        ->where('lastname', $request->input('lastname'))
                        ->get();
                }
            } else if ($request->input('type_search') == 'dni') {
                $users = User::where('dni', $request->input('search'))->get();
            } else if ($request->input('type_search') == 'cuit') {
                $users = User::where('cuit', $request->input('search'))->get();
            }
        }

        return view('usuarios.filter', compact('users'));
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

    public function update(RequestsUser $request, $id)
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
            return User::where('name', 'like', '%' . $request->input('term') . '%')
                ->orWhere('lastname', 'like', '%' . $request->input('term') . '%')
                ->get();
        }
    }
}
