<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePasswordRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Notifications\UserInviteNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        $users = User::paginate('10');
        $usersDeleted = User::onlyTrashed()->get();
        return view('usuarios.index', compact('users', 'usersDeleted'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'postal_code' => $request->input('postal_code'),
            'city' => $request->input('city'),
            'phone' => $request->input('phone'),
            'dni' => $request->input('dni'),
            'cuit' => $request->input('cuit')
        ]);

        if ($request->input('customer-role') != null) {
            $user->roles()->attach($request->input('customer-role'));
        }
        if ($request->input('provider-role') != null) {
            $user->roles()->attach($request->input('provider-role'));
        }
        if ($request->input('admin-role') != null) {
            $user->roles()->attach($request->input('admin-role'));
        }

        $user->save();

        // Email notification to set a new password        
        if ($user->email) {
            $url = URL::signedRoute('usuarios.invitation', $user);
            $user->notify(new UserInviteNotification($url));
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
        $users = null;

        if ($request->has('type_search')) {
            $users = [];
            if ($request->input('type_search') == 'name') {
                if ($request->input('name') !== null xor $request->input('lastname') !== null) {


                    $users = User::where('name', 'LIKE', '%' .  $request->input('name') . '%')
                        ->orWhere('lastname', 'LIKE', '%' .  $request->input('lastname') . '%')
                        ->get();
                } elseif ($request->input('name') && $request->input('lastname')) {
                    $users = User::where('name', 'LIKE', '%' .  $request->input('name') . '%')
                        ->where('lastname', 'LIKE', '%' .  $request->input('lastname') . '%')
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
            if ($role->id == 1) {
                $check_admin = true;
            }
            if ($role->id == 2) {
                $check_customer = true;
            }
            if ($role->id == 3) {
                $check_provider = true;
            }
        }

        return view('usuarios.edit', compact('user', 'check_customer', 'check_provider', 'check_admin', 'id'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);
        $notificate = false;

        if ($user->email == null) {
            $notificate = true;
        }

        User::where('id', $id)->update([
            'name' => $request->input('name'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'postal_code' => $request->input('postal_code'),
            'city' => $request->input('city'),
            'phone' => $request->input('phone'),
            'dni' => $request->input('dni'),
            'cuit' => $request->input('cuit')
        ]);

        $user = $user->fresh();

        // Email notification to set a new password        
        if ($user->email && $notificate) {
            $url = URL::signedRoute('usuarios.invitation', $user);
            $user->notify(new UserInviteNotification($url));
        }

        $this->setRoles($user, $request);

        return redirect()
            ->back()
            ->with('success-update', 'Usuario modificado de manera exitosa.');
    }

    private function setRoles($user, UpdateUserRequest $request)
    {
        if ($request->input('customer-checked') == false) {
            if ($request->input('customer-role') != null) {
                $user->roles()->attach($request->input('customer-role'));
            }
        } else {
            if ($request->input('customer-role') == null) {
                $user->roles()->detach(2);
            }
        }

        if ($request->input('provider-checked') == false) {
            if ($request->input('provider-role') != null) {
                $user->roles()->attach($request->input('provider-role'));
            }
        } else {
            if ($request->input('provider-role') == null) {
                $user->roles()->detach(3);
            }
        }

        if ($request->input('admin-checked') == false) {
            if ($request->input('admin-role') != null) {
                $user->roles()->attach($request->input('admin-role'));
            }
        } else {
            if ($request->input('admin-role') == null) {
                $user->roles()->detach(1);
            }
        }

        $user->save();
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()
            ->route('usuarios.index')
            ->with('success-destroy', 'Usuario eliminado con éxito.');
    }

    public function restore($id)
    {
        User::withTrashed()
            ->where('id', $id)
            ->restore();

        return redirect()
            ->route('usuarios.index')
            ->with('success-restore', 'Usuario activado con éxito.');
    }

    public function invitation(User $user)
    {
        if (!request()->hasValidSignature() || $user->password !== null) {
            abort(401);
        }
        Auth::login($user);
        return redirect()->route('dashboard');
    }

    public function setPassword()
    {
        return view('auth.passwords.setpassword');
    }

    public function setPasswordStore(StorePasswordRequest $request)
    {
        User::where('id', Auth::id())->update([
            'password' => bcrypt($request->password)
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success-password', 'Contraseña guardada con éxito.');
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
