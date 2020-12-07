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
            A continuación podrá observar la información completa de la liquidación.
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
            <label for="staticDate" class="col-sm-2 col-form-label">Tipo de </label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticDate" value="{{ ucfirst($invoice->type_invoice) }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticDate" class="col-sm-2 col-form-label">Comisión</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticDate" value="${{ $invoice->commission }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticDate" class="col-sm-2 col-form-label">Importe final</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticDate" value="${{ $invoice->total }}">
            </div>
        </div>

        <hr>

        <h4>
            <strong>Datos del {{ ucfirst($invoice->type_invoice) }}</strong>
        </h4>
        <div class="form-group row">
            <label for="staticName" class="col-sm-2 col-form-label">Nombre completo</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticName" value="{{ ucfirst($invoice->user->name) }} {{ ucfirst($invoice->user->lastname) }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $invoice->user->email ?? 'No disponible' }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticAddress" class="col-sm-2 col-form-label">Dirección</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticAddress" value="{{ ucfirst($invoice->user->address) }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticPhone" class="col-sm-2 col-form-label">Teléfono</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticPhone" value="{{ $invoice->user->phone ?? 'No disponible' }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticCp" class="col-sm-2 col-form-label">Código postal</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticCp" value="{{ $invoice->user->postal_code ?? 'No disponible' }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticCity" class="col-sm-2 col-form-label">Ciudad</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticCity" value="{{ ucfirst($invoice->user->city) ?? 'No disponible' }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticDni" class="col-sm-2 col-form-label">DNI / CUIT</label>
            <div class="col-sm-10">
                @if (isset($invoice->user->dni) && isset($invoice->user->cuit))
                <input type="text" readonly class="form-control-plaintext" id="staticDni" value="{{ $invoice->user->dni }} / {{ $invoice->user->cuit }}">
                @elseif (isset($invoice->user->dni))
                <input type="text" readonly class="form-control-plaintext" id="staticDni" value="{{ $invoice->user->dni }} / No disponible">
                @elseif (isset($invoice->user->cuit))
                <input type="text" readonly class="form-control-plaintext" id="staticDni" value="No disponible / {{ $invoice->user->cuit }}">
                @else
                <input type="text" readonly class="form-control-plaintext" id="staticDni" value="No disponible">
                @endif
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
                <label for="staticProductQuantity">Importe</label>
                <input type="text" readonly class="form-control" id="staticProductQuantity" value="${{ $product->pivot->total }}">
            </div>
            @endforeach
        </div>

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