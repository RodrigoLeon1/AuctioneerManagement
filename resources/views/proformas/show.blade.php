@extends('layouts.app')

@section('title', ' - Listar proforma')

@section('content')

@isset ($invoice)
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Información sobre proforma #{{ $invoice->id }} </h1>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            A continuación podrá observar la información completa de la proforma
        </h6>
    </div>
    <div class="card-body">
        <h4>
            <strong>Datos generales</strong>
        </h4>
        <div class="form-group row">
            <label for="remate" class="col-sm-2 col-form-label">Fecha de remate</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="remate" value="{{ date('d/m/Y', strtotime($invoice->date_remate)) }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="entrega" class="col-sm-2 col-form-label">Fecha de entrega</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="entrega" value="{{ date('d/m/Y', strtotime($invoice->date_delivery)) }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="orden" class="col-sm-2 col-form-label">Número de orden</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="orden" value="{{ $invoice->saleorder->order_number }}">
            </div>
        </div>

        <hr>
        <h4>
            <strong>Datos de la mercadería</strong>
        </h4>
        <div class="form-group row">
            <label for="codigo" class="col-sm-2 col-form-label">Código</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="codigo" value="{{ $invoice->product->id }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="description" class="col-sm-2 col-form-label">Descripción</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="description" value="{{ $invoice->product->description }}">
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <label for="quantity" class="col-sm-2 col-form-label">Cantidad</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="quantity" value="{{ $invoice->quantity }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Precio por unidad</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="" value="${{ $invoice->price_unit }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Importe</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="" value="${{ $invoice->partial_total }}">
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Comisión</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="" value="${{ $invoice->commission_value }} ({{ $invoice->commission_percentage }}%)">
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Seña</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="" value="${{ $invoice->partial_payment }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Importe total</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="" value="${{ $invoice->total }}">
            </div>
        </div>

        <hr>
        <h4>
            <strong>Datos del comprador</strong>
        </h4>
        <div class="form-group row">
            <label for="user" class="col-sm-2 col-form-label">Nombre completo</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="user" value="{{ $invoice->user->name }} {{ $invoice->user->lastname }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="user" class="col-sm-2 col-form-label">Más información sobre el comprador</label>
            <div class="col-sm-10">
                <a class="form-control-plaintext" href="{{ route('usuarios.show', $invoice->user->id) }}">
                    <i class="fas fa-user"></i>
                    Ver más
                </a>
            </div>
        </div>

        <hr>
        <a href="{{ route('proformas.pdf', $invoice->id) }}" target="_blank" class="btn btn-success btn-circle">
            <i class="fas fa-file-pdf"></i>
        </a>
        <form action="{{ route('proformas.destroy', $invoice->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('¿Desea eliminar este registro?');">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger btn-circle">
                <i class="fas fa-trash"></i>
            </button>
        </form>

    </div>
</div>
@else
<div class="container">
    <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">
            <strong>El numero de proforma ingresado no existe.</strong>
        </h4>
        <p>Probablemente el ID de la proforma no es valido. Vuelva al menu 'Listar proformas' y seleccione nuevamente.</p>
        <hr>
        <p class="mb-0">
            <a href="{{ route('proformas.index') }}" class="alert-link">Volver a 'Listar proformas'.</a>
        </p>
    </div>
</div>
@endisset

@endsection()