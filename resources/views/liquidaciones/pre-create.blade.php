<script>
    function show_name() {
        document.getElementById('name-search').style.display = "flex";
        document.getElementById('dc-search').style.display = "none";
        document.getElementById('prof-search').style.display = "none";
    }

    function show_dni() {
        document.getElementById('name-search').style.display = "none";
        document.getElementById('dc-search').style.display = "flex";
        document.getElementById('prof-search').style.display = "none";
    }

    function show_cuit() {
        document.getElementById('name-search').style.display = "none";
        document.getElementById('dc-search').style.display = "flex";
        document.getElementById('prof-search').style.display = "none";
    }

    function show_prof() {
        document.getElementById('name-search').style.display = "none";
        document.getElementById('dc-search').style.display = "none";
        document.getElementById('prof-search').style.display = "flex";
    }
</script>

@extends('layouts.app')

@section('title', ' - Crear liquidación')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Crear liquidación - {{ ucfirst($tu) }}</h1>
</div>

@if (session('success-store'))
<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">
        {{ session('success-store') }}
    </h4>
</div>
@endif

@if (session('error-search'))
<div class="alert alert-warning" role="alert">
    <h4 class="alert-heading">
        {{ session('error-search') }}
    </h4>
</div>
@endif

<!-- Content Row -->
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Es necesario buscar al usuario deseado para poder crear la liquidación</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('liquidaciones.create') }}" autocomplete="off">
                    <input type="hidden" name="tu" value="{{ $tu }}">
                    <div class="form-row justify-content-center">
                        <div class="col-md-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input radio-name" type="radio" name="type_search" id="type_search" value="name" onclick="show_name();">
                                <label class="form-check-label" for="type_search">
                                    Nombre
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input radio-dni" type="radio" name="type_search" id="type_search2" value="dni" onclick="show_dni();">
                                <label class="form-check-label" for="type_search2">
                                    DNI
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input radio-cuit" type="radio" name="type_search" id="type_search3" value="cuit" onclick="show_cuit();">
                                <label class="form-check-label" for="type_search3">
                                    CUIT
                                </label>
                            </div>
                        </div>
                        @if ($tu == 'cliente')
                        <div class="col-md-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input radio-cuit" type="radio" name="type_search" id="type_search4" value="proforma_date" onclick="show_prof();">
                                <label class="form-check-label" for="type_search4">
                                    Proforma
                                </label>
                            </div>
                        </div>
                        @endif

                    </div>

                    <div class="form-row" id="prof-search" style="display:none;">
                        <div class="form-group col-md-12 mt-5">
                            <input type="date" class="form-control" id="date" name="date">
                        </div>
                        <div class="form-group col-md-2 mt-5">
                            <button type="submit" class="btn btn-primary"> <i class="fas fa-search"></i> Filtrar</button>
                        </div>
                    </div>

                    <div class="form-row" id="dc-search" style="display:none;">
                        <div class="form-group col-md-12 mt-5">
                            <input type="search" class="form-control" id="search" name="search">
                        </div>
                        <div class="form-group col-md-2 mt-5">
                            <button type="submit" class="btn btn-primary"> <i class="fas fa-search"></i> Filtrar</button>
                        </div>
                    </div>

                    <div class="form-row" id="name-search" style="display:none; margin-top: 2rem;">
                        <div class="form-group col-md-6">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">Apellido</label>
                            <input type="text" class="form-control" id="lastname" name="lastname">
                        </div>
                        <button type="submit" class="btn btn-primary mt-3"> <i class="fas fa-search"></i> Filtrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@php $user = Session::get('user'); @endphp


@if ($user != null && count($user) > 0)
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Hay mas de un resultado para su busqueda. Seleccione el indicado.
        </h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-bordered" id="datatable-orders" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nombre completo</th>
                        <th>Domicilio</th>
                        <th>Ciudad</th>
                        <th>Teléfono</th>
                        <th>DNI</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nombre completo</th>
                        <th>Domicilio</th>
                        <th>Ciudad</th>
                        <th>Teléfono</th>
                        <th>DNI</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($user as $us)
                    <tr>
                        <td> {{ $us->name }} {{ $us->lastname }} </td>
                        <td> {{ $us->address }} </td>
                        <td> {{ $us->city }} </td>
                        <td> {{ $us->phone }} </td>
                        <td> {{ $us->dni }} </td>
                        <td>
                            <a href="{{ route('liquidaciones.create', ['user_id' => $us->id , 'tu' => $tu]) }}" class="btn btn-success btn-circle">
                                <i class="fas fa-check"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@if ($preproformas != null && count($preproformas) > 0)
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Hay mas de un resultado para su busqueda. Seleccione el indicado.
        </h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-bordered" id="datatable-orders" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nombre completo</th>
                        <th>Codigo producto</th>
                        <th>Seña</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nombre completo</th>
                        <th>Codigo producto</th>
                        <th>Seña</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                    @for ($i = 0; $i < count($preproformas); $i++) <tr>
                        <td> {{ $proformas_user[$i]->name }} {{ $proformas_user[$i]->lastname }} </td>
                        <td> {{ $preproformas[$i]->product->id }} </td>
                        <td> {{ $preproformas[$i]->partial_payment }} </td>
                        <td> {{ $preproformas[$i]->total }} </td>
                        <td>
                            <a href="{{ route('liquidaciones.create', ['user_id' => $proformas_user[$i]->id , 'tu' => $tu]) }}" class="btn btn-success btn-circle">
                                <i class="fas fa-check"></i>
                            </a>
                        </td>
                        </tr>
                        @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

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

    .user-search-container {
        margin-top: 3rem;
        width: 100%;
    }

    .user-search-input {
        width: 85%;
        height: 2.5rem;
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
        border: 2px solid #4e73df;
        border-right: none;
        padding-left: 1.5rem;
        padding-right: 1rem;
    }

    .user-search-btn {
        float: right;
        width: 15%;
        height: 2.5rem;
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
        border: 2px solid #4e73df;
        background: white;
        color: #4e73df;
    }

    .user-search-btn:hover {
        transition: all 0.5s ease;
        background: #4e73df;
        color: white;
    }

    .user-search-input:focus {
        outline: none;
    }

    .user-search-btn:focus {
        outline: none;
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

    function toggle(elemento) {
        if (elemento.value == "a") {
            document.getElementById("uno").style.display = "none";
            document.getElementById("dos").style.display = "none";
        } else {
            if (elemento.value == "b") {
                document.getElementById("uno").style.display = "block";
                document.getElementById("dos").style.display = "none";
            } else {
                if (elemento.value == "c") {
                    document.getElementById("uno").style.display = "none";
                    document.getElementById("dos").style.display = "block";
                }
            }
        }
    }
</script>

@endsection()