@extends('layouts.app')

@section('title', ' - Crear orden de venta')


@section('content')
<link href="{{ asset('vendor/jquery-ui-1.12.1/jquery-ui.min.css') }}" rel="stylesheet" type="text/css">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Crear orden de venta</h1>
</div>

<!-- Content Row -->
<div class="row">

    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Complete el formulario para crear la orden de venta</h6>
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

                <form method="POST" action="{{ route('orden-ventas.store') }}" autocomplete="off">
                    @csrf

                    <div class="form-row">
                        <div class="form-group col-md-6 {{ $errors->has('date') ? 'is-invalid' : '' }}">
                            <label for="date-order">Fecha</label>
                            <input type="date" class="form-control" id="date-order" name="date_set" value="{{ old('date_set') }}" require>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="remite-order">Remite</label>
                            <input type="number" class="form-control" id="remite-order" name="remito" value="{{ old('remito') }}" require>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="date-payment-order">Fecha de pago</label>
                            <input type="date" class="form-control" id="date-payment-order" name="date_payment" value="{{ old('date_payment') }}" require>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="id-order">Número de orden</label>
                            <input type="number" class="form-control" id="id-order" name="order_number" value="{{ old('order_number') }}" require>
                        </div>
                    </div>

                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between my-4">
                        <h6 class="m-0 font-weight-bold text-primary">Datos del usuario</h6>
                    </div>

                    <div class=" form-row">

                        <input type="hidden" id="id-user" name="id-user" value="{{ old('id-user') }}">

                        <div class="form-group col-md-3">
                            <label for="name-order">Nombre</label>
                            <input type="text" class="form-control" id="name-order" name="name-order" value="{{ old('name-order') }}">
                        </div>
                        <div class=" form-group col-md-3">
                            <label for="lastname-order">Apellido</label>
                            <input type="text" class="form-control" id="lastname-order" name="lastname-order" value="{{ old('lastname-order') }}">
                        </div>
                        <div class=" form-group col-md-4">
                            <label for="address-order">Domicilio</label>
                            <input type="text" class="form-control" id="address-order" name="address-order" value="{{ old('address-order') }}">
                        </div>
                        <div class=" form-group col-md-2">
                            <label for="phone-order">Teléfono</label>
                            <input type="text" class="form-control" id="phone-order" name="phone-order" value="{{ old('phone-order') }}">
                        </div>
                    </div>

                    <div class=" form-row">
                        <div class="form-group col-md-4">
                            <label for="cp-order">Código postal</label>
                            <input type="number" class="form-control" id="cp-order" name="cp-order" value="{{ old('cp-order') }}">
                        </div>
                        <div class=" form-group col-md-4">
                            <label for="city-order">Ciudad</label>
                            <input type="text" class="form-control" id="city-order" name="city-order" value="{{ old('city-order') }}">
                        </div>
                        <div class=" form-group col-md-4">
                            <label for="dni-order">DNI</label>
                            <input type="number" class="form-control" id="dni-order" name="dni-order" value="{{ old('dni-order') }}">
                        </div>
                    </div>

                    <div class=" card-header py-3 d-flex flex-row align-items-center justify-content-between my-4">
                        <h6 class="m-0 font-weight-bold text-primary">Agregar mercadería</h6>
                    </div>

                    @php
                    if (!empty(old('productDescription'))) {

                    $productsDescription = old('productDescription');
                    $productsQuantity = old('productQuantity');
                    $productsTasac = old('productTasac');
                    $productsTags = old('productTags');

                    foreach($productsDescription as $key => $product) {
                    echo '
                    <div data-role="dynamic-fields">
                        <div class="form-row form-dinamic">
                            <div class="form-group col-md-2">
                                <label>Descripción</label>
                                <input type="text" class="form-control" name="productDescription[]" value="' . $product . '">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Cantidad</label>
                                <input type="number" class="form-control" name="productQuantity[]" value="' . $productsQuantity[$key] . '">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Tasac</label>
                                <input type="number" class="form-control" name="productTasac[]" value="' . $productsTasac[$key] . '">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Etiquetas</label>
                                <input type="number" class="form-control" name="productTags[]" value="' . $productsTags[$key] . '">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Categoria</label>
                                <select class="form-control" name="productCategory" id="productCategory">
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <button class="btn btn-danger" data-role="remove" style="margin-top: 2rem;">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <!-- <button class="btn btn-primary" data-role="add" style="margin-top: 2rem;">
                                        <i class="fas fa-plus"></i>
                                    </button> -->
                            </div>
                        </div>
                    </div>
                    ';
                    }

                    }
                    @endphp

                    <div data-role="dynamic-fields">
                        <div class="form-row form-dinamic">
                            <div class="form-group col-md-2">
                                <label>Descripción</label>
                                <input type="text" class="form-control" name="productDescription[]">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Cantidad</label>
                                <input type="number" class="form-control" name="productQuantity[]">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Tasac</label>
                                <input type="number" class="form-control" name="productTasac[]">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Etiquetas</label>
                                <input type="number" class="form-control" name="productTags[]">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Categoria</label>
                                <select class="form-control" name="productCategory[]" id="productCategory">
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <button class="btn btn-danger" data-role="remove" style="margin-top: 2rem;">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button class="btn btn-primary" data-role="add" style="margin-top: 2rem;">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Crear orden de venta</button>
                </form>

            </div>
        </div>
    </div>

</div>

<style>
    [data-role="dynamic-fields"]>.form-dinamic+.form-dinamic {
        margin-top: 0.5em;
    }

    [data-role="dynamic-fields"]>.form-dinamic [data-role="add"] {
        display: none;
    }

    [data-role="dynamic-fields"]>.form-dinamic:last-child [data-role="add"] {
        display: inline-block;
    }

    [data-role="dynamic-fields"]>.form-dinamic:last-child [data-role="remove"] {
        display: none;
    }
</style>

<script src="https://unpkg.com/jquery@2.2.4/dist/jquery.js"></script>
<script src="{{ asset('vendor/jquery-ui-1.12.1/jquery-ui.min.js') }}"></script>
<link href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" />

<script>
    jQuery(document).ready(function($) {

        // Products inputs dinamic
        $(function() {
            // Remove button click
            $(document).on(
                'click',
                '[data-role="dynamic-fields"] > .form-dinamic [data-role="remove"]',
                function(e) {
                    e.preventDefault();
                    $(this).closest('.form-dinamic').remove();
                }
            );
            // Add button click
            $(document).on(
                'click',
                '[data-role="dynamic-fields"] > .form-dinamic [data-role="add"]',
                function(e) {
                    e.preventDefault();
                    var container = $(this).closest('[data-role="dynamic-fields"]');
                    new_field_group = container.children().filter('.form-dinamic:first-child').clone();
                    new_field_group.find('input').each(function() {
                        $(this).val('');
                    });
                    container.append(new_field_group);
                }
            );
        });

        // User inputs autocomplete
        $(function() {
            $('#name-order').autocomplete({
                source: function(request, response) {

                    $.getJSON('http://127.0.0.1:8000/api/usuarios?term=' + request.term, function(data) {
                        var array = $.map(data, function(row) {
                            return {
                                value: row.name,
                                label: row.name,
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

    });
</script>

@endsection()