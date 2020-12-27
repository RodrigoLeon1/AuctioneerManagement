@extends('layouts.app')

@section('title', ' - Crear orden de venta')

@section('content')
<link href="{{ asset('vendor/jquery-ui-1.12.1/jquery-ui.min.css') }}" rel="stylesheet" type="text/css">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Crear orden de venta</h1>
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

                <form method="POST" id="form_data" action="{{ route('orden-ventas.store') }}" onsubmit="return validateForm()" autocomplete="off">
                    @csrf

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="date-order">Fecha</label>
                            <input type="date" class="form-control {{ $errors->has('date_set') ? 'is-invalid' : '' }}" id="date-order" name="date_set" value="{{ old('date_set') }}" min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date-payment-order">Fecha de pago</label>
                            <input type="date" class="form-control {{ $errors->has('date_payment') ? 'is-invalid' : '' }}" id="date-payment-order" name="date_payment" value="{{ old('date_payment') }}" min="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="remite-order">Remito</label>
                            <input type="number" class="form-control {{ $errors->has('remito') ? 'is-invalid' : '' }}" id="remite-order" name="remito" value="{{ $lastOrder + 1 }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="id-order">Número de orden</label>
                            <input type="number" class="form-control {{ $errors->has('order_number') ? 'is-invalid' : '' }}" id="id-order" name="order_number" value="{{ $lastOrder + 1 }}" readonly>
                        </div>
                    </div>

                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between my-4">
                        <h6 class="m-0 font-weight-bold text-primary">Datos del remitente</h6>
                    </div>

                    <div class="form-row">

                        <input type="hidden" id="id-user" name="id-user" value="{{ old('id-user') }}">

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

                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between my-4">
                        <h6 class="m-0 font-weight-bold text-primary">Agregar mercadería</h6>
                    </div>

                    <div class="alert alert-danger" id="products_errors">
                        <ul>
                            <li id="products_errors_ul"></li>
                        </ul>
                    </div>

                    @if (!empty(old('productDescription')))
                    @foreach(old('productDescription') as $key => $product)
                    @if (old('productDescription')[$key] !== null)
                    <div data-role="dynamic-fields-old" id="dynamic_old_inputs">
                        <div class="form-row form-dinamic">
                            <div class="form-group col-md-5">
                                <label>Descripción</label>
                                <input type="text" class="form-control" name="productDescription[]" value="{{ old('productDescription')[$key] }}">
                            </div>
                            <div class="form-group col-md-1">
                                <label>Cantidad</label>
                                <input type="number" class="form-control" name="productQuantity[]" min=1 value="{{ old('productQuantity')[$key] }}">
                            </div>
                            <div class="form-group col-md-1">
                                <label>Tasac</label>
                                <input type="number" class="form-control" name="productTasac[]" min=0 value="{{ old('productTasac')[$key] }}">
                            </div>
                            <div class="form-group col-md-1">
                                <label>Etiquetas</label>
                                <input type="number" class="form-control" name="productTags[]" min=0 value="{{ old('productTags')[$key] }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Categoría</label>
                                <select class="form-control" name="productCategory[]" id="productCategory">
                                    @foreach ($categories as $category)
                                    @if ($category->id == old('productCategory')[$key])
                                    <option value="{{ $category->id }}" selected>{{ $category->description }}</option>
                                    @else
                                    <option value="{{ $category->id }}">{{ $category->description }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <button class="btn btn-danger to-remove" data-role="remove" style="margin-top: 2rem;">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button class="btn btn-primary" data-role="add" style="margin-top: 2rem;">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @else
                    <div data-role="dynamic-fields" id="dynamic_new_inputs">
                        <div class="form-row form-dinamic">
                            <div class="form-group col-md-5">
                                <label>Descripción</label>
                                <input type="text" class="form-control" name="productDescription[]">
                            </div>
                            <div class="form-group col-md-1">
                                <label>Cantidad</label>
                                <input type="number" class="form-control" name="productQuantity[]" min=1>
                            </div>
                            <div class="form-group col-md-1">
                                <label>Tasac</label>
                                <input type="number" class="form-control" name="productTasac[]" min=0>
                            </div>
                            <div class="form-group col-md-1">
                                <label>Etiquetas</label>
                                <input type="number" class="form-control" name="productTags[]" min=0>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Categoría</label>
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
                    @endif

                    <button type="submit" class="btn btn-primary mt-3">Crear orden de venta</button>
                    <button type="button" class="btn btn-danger mt-3" onclick="resetForm()">Resetear datos del remitente</button>
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

    [data-role="dynamic-fields-old"]>.form-dinamic:last-child [data-role="remove"] {
        display: inline-block;
    }

    #products_errors {
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

        // Products inputs old dinamic
        $(function() {
            // Remove button click
            $(document).on(
                'click',
                '[data-role="dynamic-fields-old"] > .form-dinamic [data-role="remove"]',
                function(e) {
                    e.preventDefault();
                    $(this).closest('.form-dinamic').remove();
                }
            );
            // Add button click
            $(document).on(
                'click',
                '[data-role="dynamic-fields-old"] > .form-dinamic [data-role="add"]',
                function(e) {
                    e.preventDefault();
                    var container = $(this).closest('[data-role="dynamic-fields-old"]');
                    new_field_group = container.children().filter('.form-dinamic:first-child').clone();
                    new_field_group.find('input').each(function() {
                        $(this).val('');
                    });
                    container.append(new_field_group);
                }
            );
        });

        $(function() {
            // Remove button click
            $(document).on(
                'click',
                '[data-role="dynamic-fields-old"] > .form-dinamic [data-role="remove"]',
                function(e) {
                    e.preventDefault();
                    $(this).closest('.form-dinamic').remove();
                }
            );
        });

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

    });

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

    const validateForm = () => {
        const errors = []
        const newInputsCheck = document.getElementById('dynamic_new_inputs')
        const newInputs = newInputsCheck ? newInputsCheck.getElementsByTagName('input') : null
        const newInputsArr = newInputs ? [...newInputs] : null
        const oldInputsCheck = document.getElementById('dynamic_old_inputs')
        const oldInputs = oldInputsCheck ? oldInputsCheck.getElementsByTagName('input') : null
        const oldInputsArr = oldInputs ? [...oldInputs] : null

        if (newInputsArr) {
            newInputsArr.forEach((input) => {
                if (input.name === 'productDescription[]' || input.name === 'productQuantity[]') {
                    if (!input.value) {
                        input.classList.add('is-invalid')
                        errors.push('El campo descripción y cantidad son obligatorios.')
                    }
                }
            })
        }

        if (oldInputsArr) {
            oldInputsArr.forEach((input) => {
                if (input.name === 'productDescription[]' || input.name === 'productQuantity[]') {
                    if (!input.value) {
                        input.classList.add('is-invalid')
                        errors.push('El campo descripción y cantidad son obligatorios.')
                    }
                }
            })
        }

        if (errors.length > 0) {
            document.getElementById('products_errors').style.display = 'block'
            document.getElementById('products_errors_ul').innerText = errors[0]
            return false
        }
        return true
    }
</script>

@endsection()