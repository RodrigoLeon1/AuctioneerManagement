@extends('layouts.app')

@section('title', ' - Crear proforma')

@section('content')
<link href="{{ asset('vendor/jquery-ui-1.12.1/jquery-ui.min.css') }}" rel="stylesheet" type="text/css">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Crear proforma</h1>
</div>

@if (session('error-store'))
<div class="alert alert-warning" role="alert">
    <h4 class="alert-heading">
        {{ session('error-store') }}
    </h4>
</div>
@endif

<!-- Content Row -->
<div class="row">

    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Complete el formulario para crear la proforma</h6>
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

                <form method="POST" action="{{ route('proformas.store') }}" autocomplete="off">
                    @csrf

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="date_remate">Fecha de remate</label>
                            <input type="date" class="form-control {{ $errors->has('date_remate') ? 'is-invalid' : '' }}" id="date_remate" name="date_remate" value="{{ old('date_remate') }}" require>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="date_remate_delivery">Fecha de entrega</label>
                            <input type="date" class="form-control {{ $errors->has('date_remate_delivery') ? 'is-invalid' : '' }}" id="date_remate_delivery" name="date_remate_delivery" value="{{ old('date_remate_delivery') }}" require>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="order_number">Numero de orden</label>
                            <input type="number" class="form-control {{ $errors->has('order_number') ? 'is-invalid' : '' }}" id="order_number" name="order_number" value="{{ old('order_number') }}" require>
                        </div>
                    </div>

                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between my-4">
                        <h6 class="m-0 font-weight-bold text-primary">Datos de la mercadería</h6>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Codigo</label>
                            <input type="number" class="form-control {{ $errors->has('') ? 'is-invalid' : '' }}" id="date-order" name="" value="{{ old('') }}" require>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Descripción</label>
                            <input type="text" class="form-control {{ $errors->has('') ? 'is-invalid' : '' }}" id="date-order" name="" value="{{ old('') }}" require>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Cantidad</label>
                            <input type="number" class="form-control {{ $errors->has('') ? 'is-invalid' : '' }}" id="date-order" name="" value="{{ old('') }}" require>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Precio por unidad</label>
                            <input type="text" class="form-control {{ $errors->has('') ? 'is-invalid' : '' }}" id="date-order" name="" value="{{ old('') }}" require>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Importe</label>
                            <input type="number" class="form-control {{ $errors->has('') ? 'is-invalid' : '' }}" id="date-order" name="" value="{{ old('') }}" require>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Comision</label>
                            <input type="text" class="form-control {{ $errors->has('') ? 'is-invalid' : '' }}" id="date-order" name="" value="{{ old('') }}" require>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Seña</label>
                            <input type="number" class="form-control {{ $errors->has('') ? 'is-invalid' : '' }}" id="date-order" name="" value="{{ old('') }}" require>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Importe total</label>
                            <input type="text" class="form-control {{ $errors->has('') ? 'is-invalid' : '' }}" id="date-order" name="" value="{{ old('') }}" require>
                        </div>
                    </div>

                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between my-4">
                        <h6 class="m-0 font-weight-bold text-primary">Datos del comprador</h6>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Nombre</label>
                            <input type="number" class="form-control {{ $errors->has('') ? 'is-invalid' : '' }}" id="date-order" name="" value="{{ old('') }}" require>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Crear proforma</button>
                </form>

            </div>
        </div>
    </div>

</div>

@endsection()