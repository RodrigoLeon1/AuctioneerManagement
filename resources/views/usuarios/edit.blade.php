@extends('layouts.app')

@section('title', ' - Crear orden de venta')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Modificar usuario</h1>
</div>

<!-- Content Row -->
<div class="row">

    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Modifique los campos que desee cambiar para el usuario</h6>
            </div>

            <div class="card-body">

                <form method="GET" action="{{ route('usuarios.update', $id) }}" autocomplete="off">
                    @csrf
                    <div class="form-row">
                        <div class="form-check form-check-inline col-md-2">
                            @if ($check_customer == true)
                                <input class="form-check-input" name="customer-role" type="checkbox" id="customer" value="3" checked>    
                            @else
                                <input class="form-check-input" name="customer-role" type="checkbox" id="customer" value="3">    
                            @endif
                            
                            <label class="form-check-label" for="inlineCheckbox1">Cliente</label>
                          </div>

                          <div class="form-check form-check-inline col-md-2">
                              @if ($check_provider == true)
                                <input class="form-check-input" name="provider-role" type="checkbox" id="provider" value="2" checked>      
                              @else
                                <input class="form-check-input" name="provider-role" type="checkbox" id="provider" value="2">
                              @endif
                            
                            <label class="form-check-label" for="inlineCheckbox2">Remitente</label>
                          </div>

                          <div class="form-check form-check-inline col-md-2">
                              @if ($check_admin == true)
                                <input class="form-check-input" name="admin-role" type="checkbox" id="admin" value="1" checked>      
                              @else
                                <input class="form-check-input" name="admin-role" type="checkbox" id="admin" value="1">
                              @endif
                            
                            <label class="form-check-label" for="inlineCheckbox3">Administrador</label>
                          </div>

                    </div>
                    <br><br>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user[0]->email }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user[0]->name }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="lastname">Apellido</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" value="{{ $user[0]->lastname }}">
                        </div>
                        
                    </div>

                    <div class=" form-row">
                        <div class="form-group col-md-6">
                            <label for="phone">Numero de telefono</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $user[0]->phone }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="city">Ciudad</label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ $user[0]->city }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="postal_code">Codigo postal</label>
                            <input type="number" class="form-control" id="postal_code" name="postal_code" value="{{ $user[0]->postal_code }}">
                        </div>
                    </div>

                    <div class="form-row">
                        
                        <div class="form-group col-md-4">
                            <label for="address">Domicilio</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ $user[0]->address }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="dni">DNI</label>
                            <input type="text" class="form-control" id="dni" name="dni" value="{{ $user[0]->dni }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cuit">Cuit</label>
                            <input type="text" class="form-control" id="cuit" name="cuit" value="{{ $user[0]->cuit }}">
                        </div>
                    </div>

                    <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password-repeat">Repetir contraseña</label>
                                <input type="password" class="form-control" id="password-repeat" name="password-repeat">
                            </div>

                    </div>

                    

                    

                    <button type="submit" class="btn btn-primary mt-3">Crear usuario</button>
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

    .passwords-container{
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