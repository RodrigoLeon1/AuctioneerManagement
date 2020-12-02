@extends('layouts.app')

@section('title', ' - Listar usuarios')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Listar usuarios</h1>
</div>

@if (session('success-store'))
<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">
        {{ session('success-store') }}
    </h4>
</div>
@endif

@if (session('success-destroy'))
<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">
        {{ session('success-destroy') }}
    </h4>
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
                        <th>Nombre completo</th>
                        <th>Email</th>
                        <th>Domicilio</th>
                        <th>Ciudad</th>
                        <th>Teléfono</th>
                        <th>DNI</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nombre completo</th>
                        <th>Email</th>
                        <th>Domicilio</th>
                        <th>Ciudad</th>
                        <th>Teléfono</th>
                        <th>DNI</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td> {{ $user->name }} {{ $user->lastname }} </td>
                        <td> {{ $user->email }} </td>
                        <td> {{ $user->address }} </td>
                        <td> {{ $user->city }} </td>
                        <td> {{ $user->phone }} </td>
                        <td> {{ $user->dni }} </td>
                        <td>
                            <a href="{{ route('usuarios.show', $user->id) }}" class="btn btn-info btn-circle">
                                <i class="fas fa-info-circle"></i>
                            </a>
                            <a href="{{ route('usuarios.edit', $user->id) }}" class="btn btn-warning btn-circle">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="" class="btn btn-danger btn-circle">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">No se encontraron usuarios registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection()