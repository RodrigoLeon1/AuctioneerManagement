@extends('layouts.app')

@section('title', ' - Crear liquidación')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Liquidar</h1>
</div>

<!-- Content Row -->
<div class="row">

    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Complete el formulario para liquidar</h6>
            </div>

            <div class="card-body">

                <form method="POST" action="{{ route('liquidaciones.store') }}" autocomplete="off">
                    @csrf
                    <div class="form-row">

                        <div class="form-group col-md-6">
                            <label for="date">Fecha</label>
                            <input type="date" class="form-control" id="date" name="date" value="<?php echo date('m/d/Y'); ?>">
                        </div>

                        <div class="form-group offset-md-4 col-md-1">
                            <label for="user-id">Identificador</label>
                            <input type="number" class="form-control" id="user-id" name="user-id" value="{{ $user->id }}" readonly>
                        </div>


                    </div>
                    <div class=" form-row">
                        <input type="hidden" name="user-type" id="user-role" value="{{ $role }}">
                        <div class="form-group col-md-3">
                            <label for="name-user">Nombre</label>
                            <input type="text" class="form-control" id="name-user" name="name-user" value="{{ $user->name }}" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="lastname-user">Apellido</label>
                            <input type="text" class="form-control" id="lastname-user" name="lastname-user" value="{{ $user->lastname }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email-user">Email</label>
                            <input type="text" class="form-control" id="email-user" name="email-user" value="{{ $user->email }}" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="address-user">Domicilio</label>
                            <input type="text" class="form-control" id="address-user" name="address-user" value="{{ $user->address }}" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="city-user">Ciudad</label>
                            <input type="text" class="form-control" id="city-user" name="city-user" value="{{ $user->city }}" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="cp-user">Codigo postal</label>
                            <input type="number" class="form-control" id="cp-user" name="cp-user" value="{{ $user->postal_code }}" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="phone-user">Telefono</label>
                            <input type="text" class="form-control" id="phone-user" name="phone-user" value="{{ $user->phone }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="dni-user">DNI</label>
                            <input type="number" class="form-control" id="dni-user" name="dni-user" value="{{ $user->dni }}" readonly>
                        </div>
                    </div>


                    <!-- <hr class="sidebar-divider mb-3"> -->

                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between my-4">
                        <h6 class="m-0 font-weight-bold text-primary">Listado de productos</h6>
                    </div>




                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatable-orders" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Cantidad</th>
                                        <th>Seleccionar</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Cantidad</th>
                                        <th>Seleccionar</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <div class="form-row">
                                        <?php $i = 1; ?>
                                        @foreach ($products as $product)
                                        <tr>
                                            <td> {{ ucfirst($product->description) }} </td>
                                            <td> <?php echo $i; ?> </td>
                                            <td>
                                                <input class="form-check-input" type="checkbox" value="<?php echo $product->id; ?>" name="products[]" id="user-products">
                                                <input type="hidden" value="{{ ucfirst($product->description) }} " name="products[]" id="description-products">
                                                <input type="hidden" value="<?php echo $i; ?>" name="products[]" id="quantity-products">
                                                <input type="hidden" value="200.0" name="products[]" id="price-products">
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                        @endforeach
                                    </div>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#exampleModal" onclick="modalData()">Liquidar</button>

                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Confirmar liquidacion</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="datatable-orders" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Descripción</th>
                                                        <th>Cantidad</th>
                                                        <th>Precio unitario</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Descripción</th>
                                                        <th>Cantidad</th>
                                                        <th>Precio unitario</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody id="modal-product-items">
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="datatable-orders" width="100%" cellspacing="0">

                                                <tfoot>
                                                    <tr>
                                                        <th>Subtotal</th>
                                                        <th>Comisión</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody id="">
                                                    <tr>
                                                        <td id="modal-subtotal"></td>
                                                        <td id="modal-commission"></td>
                                                        <td id="modal-total"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary">Confirmar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>

<style>
    .form-check-input {
        margin-left: 0px;
    }
</style>

<script>
    function modalData() {
        var us_products = document.getElementsByName("products[]");
        var role = document.getElementById("user-role");
        var inputs = "";
        var i = 0
        var subtotal = 0;
        var comision;
        while (i < us_products.length) {

            var is_checked = us_products[i].checked;
            if (is_checked) {
                inputs = inputs + '<tr> <td>' + us_products[i + 1].value + '</td>' +
                    '<td>' + us_products[i + 2].value + '</td>' +
                    '<td>' + us_products[i + 3].value + '</td>' +
                    '<td>' + us_products[i + 2].value * us_products[i + 3].value + '</td> </tr>';
                subtotal = subtotal + (us_products[i + 2].value * us_products[i + 3].value);
            }
            i = i + 4;
        }
        document.getElementById("modal-product-items").innerHTML = inputs;
        document.getElementById("modal-subtotal").innerHTML = "$" + subtotal;
        if (role == 3) {
            document.getElementById("modal-commission").innerHTML = subtotal * 0.2;
            document.getElementById("modal-total").innerHTML = "$" + subtotal + (subtotal * 0.2);
        } else {
            document.getElementById("modal-commission").innerHTML = subtotal * 0.1;
            document.getElementById("modal-total").innerHTML = "$" + (subtotal + (subtotal * 0.1));
        }

    }
</script>


@endsection()