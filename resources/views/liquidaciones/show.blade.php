@extends('layouts.app')

@section('title', ' - Listar liquidación')

@section('content')

@isset ($invoice)
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Información sobre la liquidación #{{ $invoice->id }} </h1>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            A continuación podrá observar la información completa de la liquidación
        </h6>
    </div>
    <div class="card-body">

        <h4>
            <strong>Datos generales</strong>
        </h4>
        <div class="form-group row">
            <label for="staticDate" class="col-sm-2 col-form-label">Fecha</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticDate" value="{{ date('d/m/Y', strtotime($invoice->created_at)) }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticDate" class="col-sm-2 col-form-label">Tipo de liquidación</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticDate" value="{{ ucfirst($invoice->type_invoice) }}">
            </div>
        </div>

        <hr>

        <h4>
            <strong>Mercadería</strong>
        </h4>
        <div class="form-row">
            @foreach ($invoice->products as $product)
            <div class="form-group col-md-4">
                <label for="staticProductName">Descripción</label>
                <input type="text" readonly class="form-control" id="staticProductName" value="{{ ucfirst($product->description) }}">
            </div>
            <div class="form-group col-md-4">
                <label for="staticProductQuantity">Cantidad total</label>
                <input type="text" readonly class="form-control" id="staticProductQuantity" value="{{ $product->pivot->quantity }}">
            </div>
            <div class="form-group col-md-4">
                <label for="staticProductQuantity">Precio por unidad</label>
                <input type="text" readonly class="form-control" id="staticProductQuantity" value="${{ number_format($product->pivot->price_unit) }}">
            </div>
            @endforeach
        </div>

        <hr>

        <div class="form-group row">
            <label for="staticDate" class="col-sm-2 col-form-label">Subtotal</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticDate" value="${{ number_format($invoice->subtotal) }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticDate" class="col-sm-2 col-form-label">Seña</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticDate" value="${{ number_format($invoice->partial_payment) }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticDate" class="col-sm-2 col-form-label">Comisión</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticDate" value="${{ number_format($invoice->commission) }} ({{ $invoice->commission_percentage }} %)">
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <label for="staticDate" class="col-sm-2 col-form-label">Importe final</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticDate" value="${{ number_format($invoice->total) }}">
            </div>
        </div>

        <hr>

        <h4>
            <strong>Datos del {{ $invoice->type_invoice }}</strong>
        </h4>
        @if ($invoice->user)
        <div class="form-group row">
            <label for="user" class="col-sm-2 col-form-label">Nombre completo</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="user" value="{{ ucwords($invoice->user->name) }} {{ ucwords($invoice->user->lastname) }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="user" class="col-sm-2 col-form-label">Más información sobre el {{ $invoice->type_invoice }}</label>
            <div class="col-sm-10">
                <a class="form-control-plaintext" href="{{ route('usuarios.show', $invoice->user->id) }}">
                    <i class="fas fa-user"></i>
                    Ver más
                </a>
            </div>
        </div>
        @else
        <div class="form-group row">
            <label for="staticName" class="col-sm-2 col-form-label">Nombre completo</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticName" value="Comprador eliminado">
            </div>
        </div>
        @endif

        <hr>

        <h4>
            <strong>Obtener liquidación en PDF</strong>
        </h4>
        <a href="{{ route('liquidaciones.pdf', $invoice->id) }}" target="_blank" class="btn btn-success btn-circle">
            <i class="fas fa-file-pdf"></i>
        </a>

    </div>
</div>
@else
<div class="container">
    <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">
            <strong>El numero de liquidación no existe.</strong>
        </h4>
        <p>Probablemente el ID de la liquidación no es valido. Vuelva al menu 'Listar liquidaciones' y seleccione nuevamente.</p>
        <hr>
        <p class="mb-0">
            <a href="{{ route('liquidaciones.index') }}" class="alert-link">Volver a 'Listar liquidaciones'.</a>
        </p>
    </div>
</div>
@endisset

@endsection()