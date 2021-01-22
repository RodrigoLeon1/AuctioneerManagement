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

@php
foreach ($product->saleorder as $order) {
$orderHc = $order->pivot;
$quantity = $order->pivot->quantity;
}
@endphp

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

                <form method="POST" action="{{ route('proformas.store') }}" autocomplete="off" id="form-proforma">
                    @csrf

                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="date_remate">Fecha de remate</label>
                            <input type="date" class="form-control {{ $errors->has('date_remate') ? 'is-invalid' : '' }}" id="date_remate" name="date_remate" value="{{ old('date_remate') }}" min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="date_delivery">Fecha de entrega</label>
                            <input type="date" class="form-control {{ $errors->has('date_delivery') ? 'is-invalid' : '' }}" id="date_delivery" name="date_delivery" value="{{ old('date_delivery') }}" min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="order_number">Número de orden</label>
                            <input type="number" class="form-control {{ $errors->has('order_number') ? 'is-invalid' : '' }}" id="order_number" name="order_number" value="{{ $order->order_number }}" readonly>
                        </div>
                    </div>

                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between my-4">
                        <h6 class="m-0 font-weight-bold text-primary">Datos de la mercadería</h6>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="product_id">Código</label>
                            <input type="number" class="form-control {{ $errors->has('product_id') ? 'is-invalid' : '' }}" id="product_id" name="product_id" value="{{ $product->id }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="product_description">Descripción</label>
                            <input type="text" class="form-control {{ $errors->has('product_description') ? 'is-invalid' : '' }}" id="product_description" name="product_description" value="{{ $product->description }}" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="quantity">Cantidad</label>
                            <input type="number" class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" id="quantity" name="quantity" value="{{ old('quantity') }}" max={{ $orderHc->quantity_remaining }} min=1>
                            <small id="quantity_small" class="form-text text-muted">
                                La mercadería <strong>{{ $product->description }}</strong> tiene una cantidad de <strong>{{ $orderHc->quantity_remaining }} unidades</strong> para vender.
                            </small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="price_unit">Precio por unidad</label>
                            <input type="number" class="form-control {{ $errors->has('price_unit') ? 'is-invalid' : '' }}" id="price_unit" name="price_unit" value="{{ old('price_unit') }}" min=1 step=".01">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="partial_total">Importe</label>
                            <input type="number" class="form-control {{ $errors->has('partial_total') ? 'is-invalid' : '' }}" id="partial_total" name="partial_total" value="{{ old('partial_total') }}" min=1 step=".01" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="partial_payment">Seña</label>
                            <input type="number" class="form-control {{ $errors->has('partial_payment') ? 'is-invalid' : '' }}" id="partial_payment" name="partial_payment" value="{{ old('partial_payment', 0) }}" min=0 step=".01">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="total">Importe total</label>
                            <input type="text" class="form-control {{ $errors->has('total') ? 'is-invalid' : '' }}" id="total" name="total" value="{{ old('total') }}" min=1 step=".01" readonly>
                        </div>
                    </div>

                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between my-4">
                        <h6 class="m-0 font-weight-bold text-primary">Datos del comprador</h6>
                    </div>

                    <div class="form-row">

                        <input type="hidden" id="id-user" name="id-user" value="{{ old('id-user', '') }}">

                        <div class="form-group col-md-3">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" value="{{ old('name') }}" {{ old('id-user') ? 'readonly' : '' }}>
                        </div>
                        <div class=" form-group col-md-3">
                            <label for="lastname">Apellido</label>
                            <input type="text" class="form-control {{ $errors->has('lastname') ? 'is-invalid' : '' }}" id="lastname" name="lastname" value="{{ old('lastname') }}" {{ old('id-user') ? 'readonly' : '' }}>
                        </div>
                        <div class=" form-group col-md-6">
                            <label for="phone">Teléfono</label>
                            <input type="number" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" id="phone" name="phone" value="{{ old('phone') }}" {{ old('id-user') ? 'readonly' : '' }}>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class=" form-group col-md-4">
                            <label for="city">Ciudad</label>
                            <input type="text" class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" id="city" name="city" value="{{ old('city') }}" {{ old('id-user') ? 'readonly' : '' }}>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="postal_code">Código postal</label>
                            <input type="number" class="form-control {{ $errors->has('postal_code') ? 'is-invalid' : '' }}" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" {{ old('id-user') ? 'readonly' : '' }}>
                        </div>
                        <div class=" form-group col-md-6">
                            <label for="address">Domicilio</label>
                            <input type="text" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" id="address" name="address" value="{{ old('address') }}" {{ old('id-user') ? 'readonly' : '' }}>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class=" form-group col-md-6">
                            <label for="dni">DNI</label>
                            <input type="number" class="form-control {{ $errors->has('dni') ? 'is-invalid' : '' }}" id="dni" name="dni" value="{{ old('dni') }}" {{ old('id-user') ? 'readonly' : '' }}>
                        </div>
                        <div class=" form-group col-md-6">
                            <label for="cuit">CUIT</label>
                            <input type="number" class="form-control {{ $errors->has('cuit') ? 'is-invalid' : '' }}" id="cuit" name="cuit" value="{{ old('cuit') }}" {{ old('id-user') ? 'readonly' : '' }}>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Crear proforma</button>
                    <button type="button" class="btn btn-danger mt-3" onclick="resetForm()">Resetear datos del comprador</button>
                </form>

            </div>
        </div>
    </div>

</div>

<script src="https://unpkg.com/jquery@2.2.4/dist/jquery.js"></script>
<script src="{{ asset('vendor/jquery-ui-1.12.1/jquery-ui.min.js') }}"></script>
<link href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" />

<script>
    const proformaForm = document.querySelector('#form-proforma')
    const quantity = document.querySelector('#quantity')
    const priceUnit = document.querySelector('#price_unit')
    const partialTotal = document.querySelector('#partial_total')
    const partial_payment = document.querySelector('#partial_payment')
    const total = document.querySelector('#total')

    quantity.addEventListener('keyup', () => {
        renderTotal()
    })
    priceUnit.addEventListener('keyup', () => {
        renderTotal()
    })
    partialTotal.addEventListener('keyup', () => {
        renderTotal()
    })
    partial_payment.addEventListener('keyup', (e) => {
        if (e.target.value && e.target.value > partialTotal.value) {
            e.target.value = 0
        }
        renderTotal()
    })

    function renderTotal() {
        partialTotal.value = parseFloat(quantity.value) * parseFloat(priceUnit.value)
        if (quantity.value && priceUnit.value) {
            let pp = parseFloat(partial_payment.value) || 0
            total.value = parseFloat(partialTotal.value) - parseFloat(pp)
        }
    }

    const resetForm = () => {
        if (confirm('Desea resetear los campos?')) {
            document.getElementById('id-user').value = ''
            document.getElementById('name').value = ''
            document.getElementById('name').readOnly = false;
            document.getElementById('lastname').value = ''
            document.getElementById('lastname').readOnly = false;
            document.getElementById('phone').value = ''
            document.getElementById('phone').readOnly = false;
            document.getElementById('city').value = ''
            document.getElementById('city').readOnly = false;
            document.getElementById('postal_code').value = ''
            document.getElementById('postal_code').readOnly = false;
            document.getElementById('address').value = ''
            document.getElementById('address').readOnly = false;
            document.getElementById('dni').value = ''
            document.getElementById('dni').readOnly = false;
            document.getElementById('cuit').value = ''
            document.getElementById('cuit').readOnly = false;
        }
    }

    // User inputs autocomplete
    $(function() {
        $('#name').autocomplete({
            source: function(request, response) {
                $.getJSON('http://127.0.0.1:8000/api/usuarios?term=' + request.term, function(data) {
                    var array = $.map(data, function(row) {
                        return {
                            value: row.name,
                            label: row.name + ' ' + row.lastname,
                            id: row.id,
                            name: row.name,
                            lastname: row.lastname,
                            address: row.address,
                            postal_code: row.postal_code,
                            city: row.city,
                            phone: row.phone,
                            dni: row.dni,
                            cuit: row.cuit
                        }
                    })
                    response($.ui.autocomplete.filter(array, request.term));
                })
            },
            minLength: 1,
            delay: 100,
            select: function(event, ui) {
                $('#id-user').val(ui.item.id)
                $('#name').val(ui.item.name)
                $('#lastname').val(ui.item.lastname)
                $('#address').val(ui.item.address)
                $('#postal_code').val(ui.item.postal_code)
                $('#city').val(ui.item.city)
                $('#phone').val(ui.item.phone)
                $('#dni').val(ui.item.dni)
                $('#cuit').val(ui.item.cuit)
                //
                document.getElementById('name').readOnly = true;
                document.getElementById('lastname').readOnly = true;
                document.getElementById('phone').readOnly = true;
                document.getElementById('city').readOnly = true;
                document.getElementById('postal_code').readOnly = true;
                document.getElementById('address').readOnly = true;
                document.getElementById('dni').readOnly = true;
                document.getElementById('cuit').readOnly = true;
            }
        })
    })
</script>

@endsection()