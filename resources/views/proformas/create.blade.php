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
                <h6 class="m-0 font-weight-bold text-primary">Complete el formulario para crear la proforma.</h6>
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
                            <input type="date" class="form-control {{ $errors->has('date_remate') ? 'is-invalid' : '' }}" id="date_remate" name="date_remate" value="{{ old('date_remate') }}" required min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="date_remate_delivery">Fecha de entrega</label>
                            <input type="date" class="form-control {{ $errors->has('date_remate_delivery') ? 'is-invalid' : '' }}" id="date_remate_delivery" name="date_remate_delivery" value="{{ old('date_remate_delivery') }}" required min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="order_number">Número de orden</label>
                            <input type="number" class="form-control {{ $errors->has('order_number') ? 'is-invalid' : '' }}" id="order_number" name="order_number" value="{{ $order->order_number }}" readonly>
                        </div>
                    </div>

                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between my-4">
                        <h6 class="m-0 font-weight-bold text-primary">Datos de la mercadería.</h6>
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
                            <input type="number" class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" id="quantity" name="quantity" value="{{ old('quantity') }}" required max={{ $orderHc->quantity_remaining }} min=1>
                            <small id="quantity" class="form-text text-muted">
                                La mercadería <strong>{{ $product->description }}</strong> tiene una cantidad de <strong>{{ $orderHc->quantity_remaining }} unidades</strong> para vender.
                            </small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="price_unit">Precio por unidad</label>
                            <input type="number" class="form-control {{ $errors->has('price_unit') ? 'is-invalid' : '' }}" id="price_unit" name="price_unit" value="{{ old('price_unit') }}" min=1 step=".01" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="partial_total">Importe</label>
                            <input type="number" class="form-control {{ $errors->has('partial_total') ? 'is-invalid' : '' }}" id="partial_total" name="partial_total" value="{{ old('partial_total') }}" min=1 step=".01" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="commission">Comisión en porcentaje</label>
                            <input type="number" class="form-control {{ $errors->has('commission') ? 'is-invalid' : '' }}" id="commission" name="commission" value="{{ old('commission', 10) }}" min="1" max="100">
                            <small class="form-text text-muted">
                                El importe de la <strong>comisión</strong> sera $<strong id="commission_str">0</strong>.
                                <input type="hidden" id="commission_value" name="commission_value">
                            </small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="partial_payment">Seña</label>
                            <input type="number" class="form-control {{ $errors->has('partial_payment') ? 'is-invalid' : '' }}" id="partial_payment" name="partial_payment" value="{{ old('partial_payment', 0) }}" min=0 step=".01" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="total">Importe total</label>
                            <input type="text" class="form-control {{ $errors->has('total') ? 'is-invalid' : '' }}" id="total" name="total" value="{{ old('total') }}" min=1 step=".01" readonly>
                        </div>
                    </div>

                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between my-4">
                        <h6 class="m-0 font-weight-bold text-primary">Datos del comprador.</h6>
                    </div>

                    <div class="form-row">

                        <input type="hidden" id="id-user" name="id-user" value="{{ old('id-user') }}">

                        <div class="form-group col-md-3">
                            <label for="name-order">Nombre</label>
                            <input type="text" class="form-control" id="name-order" name="name-order" value="{{ old('name-order') }}">
                        </div>
                        <div class=" form-group col-md-3">
                            <label for="lastname-order">Apellido</label>
                            <input type="text" class="form-control" id="lastname-order" name="lastname-order" value="{{ old('lastname-order') }}">
                        </div>
                        <div class=" form-group col-md-6">
                            <label for="phone-order">Teléfono</label>
                            <input type="text" class="form-control" id="phone-order" name="phone-order" value="{{ old('phone-order') }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class=" form-group col-md-4">
                            <label for="city-order">Ciudad</label>
                            <input type="text" class="form-control" id="city-order" name="city-order" value="{{ old('city-order') }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="cp-order">Código postal</label>
                            <input type="number" class="form-control" id="cp-order" name="cp-order" value="{{ old('cp-order') }}">
                        </div>
                        <div class=" form-group col-md-6">
                            <label for="address-order">Domicilio</label>
                            <input type="text" class="form-control" id="address-order" name="address-order" value="{{ old('address-order') }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class=" form-group col-md-6">
                            <label for="dni-order">DNI</label>
                            <input type="number" class="form-control" id="dni-order" name="dni-order" value="{{ old('dni-order') }}">
                        </div>
                        <div class=" form-group col-md-6">
                            <label for="cuit-order">CUIT</label>
                            <input type="number" class="form-control" id="cuit-order" name="cuit-order" value="{{ old('cuit-order') }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Crear proforma</button>
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
    const commission = document.querySelector('#commission')
    const commission_total = document.querySelector('#commission_str')
    const commission_value = document.querySelector('#commission_value')
    const partial_payment = document.querySelector('#partial_payment')
    const total = document.querySelector('#total')

    quantity.addEventListener('blur', () => {
        renderTotal()
    })
    priceUnit.addEventListener('blur', () => {
        renderTotal()
    })
    partialTotal.addEventListener('blur', () => {
        renderTotal()
    })
    commission.addEventListener('blur', () => {
        renderTotal()
    })
    partial_payment.addEventListener('blur', () => {
        renderTotal()
    })

    function renderTotal() {
        partialTotal.value = parseFloat(quantity.value) * parseFloat(priceUnit.value)
        if (quantity.value && priceUnit.value) {
            commission_total.innerText = parseFloat(partialTotal.value) * (commission.value / 100)
            total.value = parseFloat(partialTotal.value) + parseFloat(commission_total.innerText) - parseFloat(partial_payment.value)
            commission_value.value = parseFloat(commission_total.innerText)
        }

    }

    // User inputs autocomplete
    $(function() {
        $('#name-order').autocomplete({
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
                        }
                    })
                    response($.ui.autocomplete.filter(array, request.term));
                })
            },
            minLength: 1,
            delay: 100,
            select: function(event, ui) {
                $('#id-user').val(ui.item.id)
                $('#name-order').val(ui.item.name)
                $('#lastname-order').val(ui.item.lastname)
                $('#address-order').val(ui.item.address)
                $('#cp-order').val(ui.item.postal_code)
                $('#city-order').val(ui.item.city)
                $('#phone-order').val(ui.item.phone)
                $('#dni-order').val(ui.item.dni)
            }
        })
    })
</script>

@endsection()