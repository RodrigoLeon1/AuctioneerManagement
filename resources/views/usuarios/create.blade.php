@extends('layouts.app')

@section('title', ' - Crear usuario')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Crear usuario</h1>
</div>

<!-- Content Row -->
<div class="row">

    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Complete el formulario para crear al usuario</h6>
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

                <form method="POST" action="{{ route('usuarios.store') }}" autocomplete="off" onsubmit="return checkRoleInput()">
                    @csrf
                    <div class="form-row mb-5">
                        <div class="form-check form-check-inline col-md-3">
                            <label class="form-check-label">
                                Seleccione el rol o roles del usuario
                            </label>
                        </div>
                        <div class="form-check form-check-inline col-md-2">
                            <input class="form-check-input" name="admin-role" type="checkbox" id="admin" value="1" {{ (old('admin-role')) ? "checked" : "" }}>
                            <label class="form-check-label" for="inlineCheckbox3">Administrador</label>
                        </div>
                        <div class="form-check form-check-inline col-md-2">
                            <input class="form-check-input" name="customer-role" type="checkbox" id="customer" value="2" {{ (old('customer-role')) ? "checked" : "" }}>
                            <label class="form-check-label" for="inlineCheckbox1">Cliente</label>
                        </div>

                        <div class="form-check form-check-inline col-md-2">
                            <input class="form-check-input" name="provider-role" type="checkbox" id="provider" value="3" {{ (old('provider-role')) ? "checked" : "" }}>
                            <label class="form-check-label" for="inlineCheckbox2">Remitente</label>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" value="{{ old('name') }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="lastname">Apellido</label>
                            <input type="text" class="form-control {{ $errors->has('lastname') ? 'is-invalid' : '' }}" id="lastname" name="lastname" value="{{ old('lastname') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">Teléfono</label>
                            <input type="number" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" id="phone" name="phone" value="{{ old('phone') }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="city">Ciudad</label>
                            <input type="text" class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" id="city" name="city" value="{{ old('city') }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="postal_code">Código postal</label>
                            <input type="number" class="form-control {{ $errors->has('postal_code') ? 'is-invalid' : '' }}" id="postal_code" name="postal_code" value="{{ old('postal_code') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address">Domicilio</label>
                            <input type="text" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" id="address" name="address" value="{{ old('address') }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="dni">DNI</label>
                            <input type="number" class="form-control {{ $errors->has('dni') ? 'is-invalid' : '' }}" id="dni" name="dni" value="{{ old('dni') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cuit">CUIT</label>
                            <input type="number" class="form-control {{ $errors->has('cuit') ? 'is-invalid' : '' }}" id="cuit" name="cuit" value="{{ old('cuit') }}">
                        </div>
                    </div>

                    <div class=" card-header py-3 d-flex flex-row align-items-center justify-content-between my-4">
                        <h6 class="m-0 font-weight-bold text-primary">Datos de accesso</h6>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="email">Email</label>
                            <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email" value="{{ old('email') }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Crear usuario</button>
                </form>

            </div>
        </div>
    </div>

</div>

<script>
    const adminInput = document.querySelector('#admin')
    const customerInput = document.querySelector('#customer')
    const providerInput = document.querySelector('#provider')

    const checkRoleInput = (e) => {
        if (adminInput.checked || customerInput.checked || providerInput.checked) {
            if (adminInput.checked) {
                let result = confirm('¡Cuidado! Ha seleccionado el ROL ADMINISTRADOR. Si desea continuar, el usuario podrá realizar las siguientes operaciones: Gestionar órdenes de venta, Gestionar proformas, Gestionar liquidaciones, Gestionar mercaderías y gestionar usuarios. ¿Desea continuar?')

                if (!result) return false
            }
        } else {
            alert('Para poder continuar, es necesario establecer al menos un rol para el usuario. En caso de no estar seguro de cual elegir, recomendamos seleccionar el ROL CLIENTE.')
            return false
        }
    }
</script>

@endsection()