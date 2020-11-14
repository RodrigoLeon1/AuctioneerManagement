@extends('layouts.app')

@section('title', ' - Listar ordenes de venta')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Listar usuarios</h1>
</div>

@if (app('request')->input('success') == 1)
<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">El usuario ha sido creada de manera exitosa.</h4>
</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            A continuación podrá observar el listado de usuarios.
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="datatable-orders" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Rol</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Ciudad</th>
                        <th>Domicilio</th>
                        <th>Teléfono</th>
                        <th>DNI</th>
                        <th>CUIT</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Rol</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Ciudad</th>
                        <th>Domicilio</th>
                        <th>Teléfono</th>
                        <th>DNI</th>
                        <th>CUIT</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>
                            @foreach ($user->roles as $role)
                            {{ $role->description }}
                            @endforeach

                        </td>
                        <td> {{ $user->name }} </td>
                        <td> {{ $user->lastname }} </td>
                        <td> {{ $user->email }} </td>
                        <td> {{ $user->city }} </td>
                        <td> {{ $user->address }} </td>
                        <td> {{ $user->phone }} </td>
                        <td> {{ $user->dni }} </td>
                        <td> {{ $user->cuit }} </td>
                        <td>
                            <a href="{{ route('usuarios.edit', $user->id) }}" class="btn btn-info btn-circle">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="" class="btn btn-danger btn-circle">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection()