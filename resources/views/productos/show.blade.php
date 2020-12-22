@extends('layouts.app')

@section('title', ' - Listar mercadería')

@section('content')

@isset ($product)
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Información sobre mercadería </h1>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            A continuación podrá observar la información completa de la mercadería.
        </h6>
    </div>
    <div class="card-body">

        <h4>
            <strong>Datos generales</strong>
        </h4>
        <div class="form-group row">
            <label for="staticDate" class="col-sm-2 col-form-label">Fecha de creación</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticDate" value="{{ date('d/m/Y', strtotime($product->created_at)) }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticDate" class="col-sm-2 col-form-label">Código</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticDate" value="{{ $product->id }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticDate" class="col-sm-2 col-form-label">Descripción</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticDate" value="{{ $product->description }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="staticDate" class="col-sm-2 col-form-label">Categoría</label>
            <div class="col-sm-10">
                @foreach ($product->categories as $category)
                <input type="text" readonly class="form-control-plaintext" id="staticDate" value="{{ $category->description }}">
                @endforeach
            </div>
        </div>

        <hr>
        @foreach ($product->saleorder as $saleorder)
        <p>
            Esta mercadería fue dada de alta en la <strong>Orden de venta #{{ $saleorder->order_number }}</strong>.
        </p>
        <p>
            Si desea ver la información completa de la orden de venta, clickee el siguiente enlace.
            <a href="{{ route('orden-ventas.show', $saleorder->id) }}">Información completa</a>
        </p>
        @endforeach

        <hr>
        <a href="{{ route('productos.edit', $product->id) }}" class="btn btn-warning btn-circle">
            <i class="fas fa-edit"></i>
        </a>
    </div>
</div>
@else
<div class="container">
    <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">
            <strong>La mercadería ingresada no existe.</strong>
        </h4>
        <p>Probablemente el ID de la mercadería no es valido. Vuelva al menu 'Listar mercaderia' y seleccione nuevamente.</p>
        <hr>
        <p class="mb-0">
            <a href="{{ route('productos.index') }}" class="alert-link">Volver a 'Listar mercaderia'.</a>
        </p>
    </div>
</div>
@endisset

@endsection()