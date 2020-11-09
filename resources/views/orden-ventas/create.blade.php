@extends('layouts.app')

@section('title', ' - Crear orden de venta')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Crear orden de venta</h1>
</div>

<!-- Content Row -->
<div class="row">

    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Complete el formulario para crear la orden de venta</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">

                <form method="POST" action="{{ route('orden-ventas.store') }}">
                    @csrf
                    <div class="form-row">

                        <div class="form-group col-md-6 {{ $errors->has('date') ? 'is-invalid' : '' }}">
                            <label for="date-order">Fecha</label>
                            <input type="date" class="form-control" id="date-order" name="date-order">
                        </div>
                        @if($errors->has('date'))
                        <div class="invalid-feedback">
                            {{ $errors->first('date') }}
                        </div>
                        @endif

                        <div class="form-group col-md-6">
                            <label for="remite-order">Remite</label>
                            <input type="number" class="form-control" id="remite-order" name="remite-order">
                        </div>
                    </div>
                    <div class=" form-row">
                        <div class="form-group col-md-6">
                            <label for="name-order">Nombre</label>
                            <input type="text" class="form-control" id="name-order" name="name-order">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="address-order">Domicilio</label>
                            <input type="text" class="form-control" id="address-order" name="address-order">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="phone-order">Telefono</label>
                            <input type="text" class="form-control" id="phone-order" name="phone-order">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="cp-order">Codigo postal</label>
                            <input type="number" class="form-control" id="cp-order" name="cp-order">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="city-order">Ciudad</label>
                            <input type="text" class="form-control" id="city-order" name="city-order">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="dni-order">DNI</label>
                            <input type="number" class="form-control" id="dni-order" name="dni-order">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="date-payment-order">Fecha de pago</label>
                            <input type="date" class="form-control" id="date-payment-order" name="date-payment-order">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="id-order">Numero de orden</label>
                            <input type="number" class="form-control" id="id-order" name="id-order">
                        </div>
                    </div>

                    <!-- <hr class="sidebar-divider mb-3"> -->

                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between my-4">
                        <h6 class="m-0 font-weight-bold text-primary">Agregar mercaderia</h6>
                    </div>

                    <div data-role="dynamic-fields">
                        <div class="form-row form-dinamic">
                            <div class="form-group col-md-3">
                                <label for="date-payment-order">Descripcion</label>
                                <input type="date" class="form-control" id="date-payment-order" name="date-payment-order">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="">Cantidad</label>
                                <input type="number" class="form-control" id="" name="">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Tasac</label>
                                <input type="number" class="form-control" id="" name="">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="">Etiquetas</label>
                                <input type="number" class="form-control" id="" name="">
                            </div>

                            <div class="form-group col-md-2">
                                <button class="btn btn-danger" data-role="remove">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                                <button class="btn btn-primary" data-role="add">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
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

<script>
    jQuery(document).ready(function($) {
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
    });
</script>

@endsection()