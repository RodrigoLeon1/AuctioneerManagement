@extends('layouts.app')

@section('title', ' - Editar usuario')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Editar usuario</h1>
</div>

@if (session('success-update'))
<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">
        {{ session('success-update') }}
    </h4>
</div>
@endif

<!-- Content Row -->
<div class="row">

    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Edité los campos que desee cambiar para el usuario</h6>
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

                <form method="POST" action="{{ route('usuarios.update', $id) }}" autocomplete="off">

                    @csrf
                    @method('PUT')

                    <div class="form-row mb-5">
                        <div class="form-check form-check-inline col-md-3">
                            <label class="form-check-label">
                                Modifique el rol o roles del usuario
                            </label>
                        </div>

                        <div class="form-check form-check-inline col-md-2">
                            @if ($check_admin == true)
                            <input class="form-check-input" name="admin-role" type="checkbox" id="admin" value="1" checked>
                            @else
                            <input class="form-check-input" name="admin-role" type="checkbox" id="admin" value="1">
                            @endif

                            <label class="form-check-label" for="inlineCheckbox3">Administrador</label>
                        </div>

                        <div class="form-check form-check-inline col-md-2">
                            @if ($check_customer == true)
                            <input class="form-check-input" name="customer-role" type="checkbox" id="customer" value="2" checked>
                            @else
                            <input class="form-check-input" name="customer-role" type="checkbox" id="customer" value="2">
                            @endif

                            <label class="form-check-label" for="inlineCheckbox1">Cliente</label>
                        </div>

                        <div class="form-check form-check-inline col-md-2">
                            @if ($check_provider == true)
                            <input class="form-check-input" name="provider-role" type="checkbox" id="provider" value="3" checked>
                            @else
                            <input class="form-check-input" name="provider-role" type="checkbox" id="provider" value="3">
                            @endif

                            <label class="form-check-label" for="inlineCheckbox2">Remitente</label>
                        </div>

                    </div>

                    <div class="form-row">

                        <div class="form-group col-md-3">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" value="{{ old('name', $user[0]->name) }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="lastname">Apellido</label>
                            <input type="text" class="form-control {{ $errors->has('lastname') ? 'is-invalid' : '' }}" id="lastname" name="lastname" value="{{ old('lastname', $user[0]->lastname) }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">Teléfono</label>
                            <input type="text" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" id="phone" name="phone" value="{{ old('phone', $user[0]->phone) }}">
                        </div>
                    </div>

                    <div class=" form-row">
                        <div class="form-group col-md-4">
                            <label for="city">Ciudad</label>
                            <input type="text" class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" id="city" name="city" value="{{ old('city', $user[0]->city) }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="postal_code">Código postal</label>
                            <input type="number" class="form-control {{ $errors->has('postal_code') ? 'is-invalid' : '' }}" id="postal_code" name="postal_code" value="{{ old('postal_code', $user[0]->postal_code) }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address">Domicilio</label>
                            <input type="text" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" id="address" name="address" value="{{ old('address', $user[0]->address) }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="dni">DNI</label>
                            <input type="number" class="form-control {{ $errors->has('dni') ? 'is-invalid' : '' }}" id="dni" name="dni" value="{{ old('dni', $user[0]->dni) }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cuit">CUIT</label>
                            <input type="number" class="form-control {{ $errors->has('cuit') ? 'is-invalid' : '' }}" id="cuit" name="cuit" value="{{ old('cuit', $user[0]->cuit) }}">
                        </div>
                    </div>

                    <div class=" card-header py-3 d-flex flex-row align-items-center justify-content-between my-4">
                        <h6 class="m-0 font-weight-bold text-primary">Datos de accesso</h6>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="email">Email</label>
                            <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email" value="{{ old('email', $user[0]->email) }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Editar usuario</button>
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

    .passwords-container {
        display: flex;
        transition: all 10s ease;
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