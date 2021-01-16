@extends('layouts.app')

@section('title', ' - Editar liquidación')

@section('content')

@isset ($invoice)
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Editar información de la liquidación #{{ $invoice->id }} </h1>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            A continuación podrá editar la información de la liquidación
        </h6>
    </div>
    <div class="card-body">

      @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
      @endif

      <form action="{{ route('liquidaciones.update', $invoice->id) }}" method="post">    
        @csrf
        @method('PUT')    
        <div class="form-row form-dinamic">
          <div class="form-group col-md-12">
              <label>Precio modificado</label>
              <input type="number" class="form-control {{ $errors->has('price_modified') ? 'is-invalid' : '' }}" name="price_modified" id="price_modified" value="{{ old('price_modified') }}" required>
          </div>
          <div class="form-group col-md-12">
              <label>Motivo por el cual se ha de modificar el precio</label>
              <textarea class="form-control" id="description_modified" name="description_modified" rows="3" required></textarea>
          </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Editar liquidación</button>
      </form>

        <h4 class="mt-5">
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
            <div class="form-group col-md-6">
                <label for="staticProductName">Descripción</label>
                <input type="text" readonly class="form-control" id="staticProductName" value="{{ ucfirst($product->description) }}">
            </div>
            <div class="form-group col-md-3">
                <label for="staticProductQuantity">Cantidad total</label>
                <input type="text" readonly class="form-control" id="staticProductQuantity" value="{{ $product->pivot->quantity }}">
            </div>
            <div class="form-group col-md-3">
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
            <label for="staticDate" class="col-sm-2 col-form-label">Importe final original</label>
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