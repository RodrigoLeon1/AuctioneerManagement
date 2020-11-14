@extends('layouts.app')

@section('title', ' - Listar ordenes de venta')

@section('content')

@isset ($order)
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Informacion sobre orden de venta #{{ $order->id }} </h1>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            A continuacion podra observar la informacion completa de la orden de venta.
        </h6>
    </div>
    <div class="card-body">

        <h4>
            <strong>Datos generales</strong>
        </h4>
        <div class="form-group row">
            <label for="staticDate" class="col-sm-2 col-form-label">Fecha</label>
            <div class="col-sm-10">
                <input type="date" readonly class="form-control-plaintext" id="staticDate" value="{{ $order->date_set }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticRemito" class="col-sm-2 col-form-label">Remito</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticRemito" value="{{ $order->remito }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticDatePayment" class="col-sm-2 col-form-label">Fecha de pago</label>
            <div class="col-sm-10">
                <input type="date" readonly class="form-control-plaintext" id="staticDatePayment" value="{{ $order->date_payment }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticOrderNumber" class="col-sm-2 col-form-label">Numero de orden</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticOrderNumber" value="{{ $order->order_number }}">
            </div>
        </div>

        <hr>

        <h4>
            <strong>Datos del usuario</strong>
        </h4>
        <div class="form-group row">
            <label for="staticName" class="col-sm-2 col-form-label">Nombre completo</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticName" value="{{ ucfirst($order->user->name) }} {{ ucfirst($order->user->lastname) }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $order->user->email ?? 'No disponible' }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticAddress" class="col-sm-2 col-form-label">Direccion</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticAddress" value="{{ ucfirst($order->user->address) }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticPhone" class="col-sm-2 col-form-label">Telefono</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticPhone" value="{{ $order->user->phone ?? 'No disponible' }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticCp" class="col-sm-2 col-form-label">Codigo postal</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticCp" value="{{ $order->user->postal_code ?? 'No disponible' }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticCity" class="col-sm-2 col-form-label">Ciudad</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticCity" value="{{ ucfirst($order->user->city) ?? 'No disponible' }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticDni" class="col-sm-2 col-form-label">DNI / CUIT</label>
            <div class="col-sm-10">
                @if (isset($order->user->dni) && isset($order->user->cuit))
                <input type="text" readonly class="form-control-plaintext" id="staticDni" value="{{ $order->user->dni }} / {{ $order->user->cuit }}">
                @elseif (isset($order->user->dni))
                <input type="text" readonly class="form-control-plaintext" id="staticDni" value="{{ $order->user->dni }} / No disponible">
                @elseif (isset($order->user->cuit))
                <input type="text" readonly class="form-control-plaintext" id="staticDni" value="No disponible / {{ $order->user->cuit }}">
                @else
                <input type="text" readonly class="form-control-plaintext" id="staticDni" value="No disponible">
                @endif
            </div>
        </div>

        <hr>

        <h4>
            <strong>Mercaderia</strong>
        </h4>
        <div class="form-row">
            @foreach ($order->products as $product)
            <div class="form-group col-md-3">
                <label for="staticProductName">Descripcion</label>
                <input type="text" readonly class="form-control" id="staticProductName" value="{{ ucfirst($product->description) }}">
            </div>
            <div class="form-group col-md-3">
                <label for="staticProductQuantity">Cantidad</label>
                <input type="text" readonly class="form-control" id="staticProductQuantity" value="{{ $product->pivot->quantity }}">
            </div>
            <div class="form-group col-md-3">
                <label for="staticProductTasac">Tasac</label>
                <input type="text" readonly class="form-control" id="staticProductTasac" value="">
            </div>
            <div class="form-group col-md-3">
                <label for="staticProductTags">Etiquetas</label>
                <input type="text" readonly class="form-control" id="staticProductTags" value="{{ $product->pivot->quantity_tags }}">
            </div>
            @endforeach
        </div>

        <hr>

        <h4>
            <strong>Obtener factura en PDF</strong>
        </h4>
        <a href="{{ route('orden-ventas.pdf', $order->id) }}" class="btn btn-success btn-circle">
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