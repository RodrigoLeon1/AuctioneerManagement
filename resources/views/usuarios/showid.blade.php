@extends('layouts.app')

@section('title', ' - Listar usuario')

@section('content')

@isset ($user)
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Información sobre el usuario <strong>{{ $user->name }} {{ $user->lastname }}</strong> </h1>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            A continuación podrá observar la información completa de la usuario.
        </h6>
    </div>
    <div class="card-body">

        <h4>
            <strong>Datos generales</strong>
        </h4>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Nombre</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="name" value="{{ $user->name }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="lastname" class="col-sm-2 col-form-label">Apellido</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="lastname" value="{{ $user->lastname }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="phone" class="col-sm-2 col-form-label">Teléfono</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="phone" value="{{ $user->phone }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="city" class="col-sm-2 col-form-label">Ciudad</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="city" value="{{ $user->city }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="cp" class="col-sm-2 col-form-label">Código postal</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="cp" value="{{ $user->postal_code }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="address" class="col-sm-2 col-form-label">Domicilio</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="address" value="{{ $user->address }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="dni" class="col-sm-2 col-form-label">DNI</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="dni" value="{{ $user->dni }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="cuit" class="col-sm-2 col-form-label">CUIT</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="cuit" value="{{ $user->cuit }}">
            </div>
        </div>


        <hr>
        <h4>
            <strong>Órdenes de ventas asociadas al usuario</strong>
        </h4>
        <ul>
            @forelse ($user->saleorders as $order)
            <li>{{ $order->date_set }} - <a href="{{ route('orden-ventas.show', $order->id) }}">Más información</a></li>
            @empty
            <li>No se encontraron órdenes de venta asociadas al usuario.</li>
            @endforelse
        </ul>


        <hr>
        <h4>
            <strong>Liquidaciones asociadas al usuario</strong>
        </h4>
        <ul>
            @forelse ($user->invoices as $invoice)
            <li>{{ $invoice->date_set }} - <a href="{{ route('orden-ventas.show', $invoice->id) }}">Más información</a></li>
            @empty
            <li>No se encontraron liquidaciones asociadas al usuario.</li>
            @endforelse
        </ul>

    </div>
</div>
@else
<div class="container">
    <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">
            <strong>El numero de usuario ingresado no existe.</strong>
        </h4>
        <p>Probablemente el ID de la usuario no es valido. Vuelva al menu 'Listar usuarios' y seleccione nuevamente.</p>
        <hr>
        <p class="mb-0">
            <a href="{{ route('usuarios.index') }}" class="alert-link">Volver a 'Listar usuarios'.</a>
        </p>
    </div>
</div>
@endisset

@endsection()