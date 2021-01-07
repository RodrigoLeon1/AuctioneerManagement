@extends('layouts.app')

@section('title', ' - Listar orden de venta')

@section('content')

@isset ($order)
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Información sobre orden de venta #{{ $order->id }} </h1>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            A continuación podrá observar la información completa de la orden de venta
        </h6>
    </div>
    <div class="card-body">

        <h4>
            <strong>Datos generales</strong>
        </h4>
        <div class="form-group row">
            <label for="staticDate" class="col-sm-2 col-form-label">Fecha</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticDate" value="{{ date('d/m/Y', strtotime($order->date_set)) }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticDatePayment" class="col-sm-2 col-form-label">Fecha de pago</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticDatePayment" value="{{ date('d/m/Y', strtotime($order->date_payment)) }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticRemito" class="col-sm-2 col-form-label">Remito</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticRemito" value="{{ $order->remito }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticOrderNumber" class="col-sm-2 col-form-label">Número de orden</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticOrderNumber" value="{{ $order->order_number }}">
            </div>
        </div>

        <hr>

        <h4>
            <strong>Mercadería</strong>
        </h4>
        <div class="form-row">
            @foreach ($order->products as $product)
            <div class="form-group col-md-2">
                <label for="staticProductTasac">Código</label>
                <input type="text" readonly class="form-control" id="staticProductTasac" value="{{ $product->id }}">
            </div>
            <div class="form-group col-md-3">
                <label for="staticProductName">Descripción</label>
                <input type="text" readonly class="form-control" id="staticProductName" value="{{ ucfirst($product->description) }}">
            </div>
            <div class="form-group col-md-2">
                <label for="staticProductQuantity">Cantidad total</label>
                <input type="text" readonly class="form-control" id="staticProductQuantity" value="{{ $product->pivot->quantity }}">
            </div>
            <div class="form-group col-md-3">
                <label for="staticProductQuantityRemaining">Cantidad disponible para vender</label>
                <input type="text" readonly class="form-control" id="staticProductQuantityRemaining" value="{{ $product->pivot->quantity_remaining }}">
            </div>
            <div class="form-group col-md-2">
                <label for="staticProductCategory">Categoría</label>
                @forelse ($product->categories as $category)
                <input type="text" readonly class="form-control" id="staticProductCategory" value="{{ $category->description }}">
                @empty
                <input type="text" readonly class="form-control" id="staticProductCategory" value="Sin categoría">
                @endforelse
            </div>
            @endforeach
        </div>

        <hr>

        <h4>
            <strong>Datos del remitente</strong>
        </h4>
        @if ($order->user)
        <div class="form-group row">
            <label for="user" class="col-sm-2 col-form-label">Nombre completo</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="user" value="{{ ucwords($order->user->name) }} {{ ucwords($order->user->lastname) }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="user" class="col-sm-2 col-form-label">Más información sobre el remitente</label>
            <div class="col-sm-10">
                <a class="form-control-plaintext" href="{{ route('usuarios.show', $order->user->id) }}">
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
            <strong>Obtener factura en PDF</strong>
        </h4>
        <a href="{{ route('orden-ventas.pdf', $order->id) }}" target="_blank" class="btn btn-success btn-circle">
            <i class="fas fa-file-pdf"></i>
        </a>

    </div>
</div>
@else
<div class="container">
    <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">
            <strong>El numero de orden ingresado no existe.</strong>
        </h4>
        <p>Probablemente el ID de la orden de venta no es valido. Vuelva al menu 'Listar ordenes' y seleccione nuevamente.</p>
        <hr>
        <p class="mb-0">
            <a href="{{ route('orden-ventas.index') }}" class="alert-link">Volver a 'Listar ordenes'.</a>
        </p>
    </div>
</div>
@endisset

@endsection()