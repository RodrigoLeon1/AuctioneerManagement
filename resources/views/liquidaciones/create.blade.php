@extends('layouts.app')

@section('title', ' - Crear liquidación')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Crear liquidación - {{ ucfirst($tu) }}</h1>
</div>

<!-- Content Row -->
<div class="row">

    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Complete el formulario para crear la liquidación</h6>
            </div>

            <div class="card-body">

                <form method="POST" action="{{ route('liquidaciones.store') }}" autocomplete="off" onsubmit="return checkSubmit()">

                    @csrf

                    <div class="form-row">
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <div class="form-group col-md-3">
                            <label for="name-order">Nombre</label>
                            <input type="text" class="form-control" id="name-user" value="{{ $user->name }}" readonly>
                        </div>
                        <div class=" form-group col-md-3">
                            <label for="lastname-order">Apellido</label>
                            <input type="text" class="form-control" id="lastname-user" value="{{ $user->lastname }}" readonly>
                        </div>
                        <div class=" form-group col-md-6">
                            <label for="phone-order">Teléfono</label>
                            <input type="text" class="form-control" id="phone-user" value="{{ $user->phone }}" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class=" form-group col-md-4">
                            <label for="city-order">Ciudad</label>
                            <input type="text" class="form-control" id="city-user" value="{{ $user->city }}" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="cp-order">Código postal</label>
                            <input type="number" class="form-control" id="cp-user" value="{{ $user->postal_code }}" readonly>
                        </div>
                        <div class=" form-group col-md-6">
                            <label for="address-order">Domicilio</label>
                            <input type="text" class="form-control" id="address-user" value="{{ $user->address }}" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class=" form-group col-md-6">
                            <label for="dni-order">DNI</label>
                            <input type="number" class="form-control" id="dni-user" value="{{ $user->dni }}" readonly>
                        </div>
                        <div class=" form-group col-md-6">
                            <label for="cuit-order">CUIT</label>
                            <input type="number" class="form-control" id="cuit-user" value="{{ $user->cuit }}" readonly>
                        </div>
                    </div>

                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between my-4">
                        <h6 class="m-0 font-weight-bold text-primary">Listado de mercaderías asociadas al usuario según las proformas previamente creadas, y que todavía no han sido asociadas a una liquidación</h6>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            @if ($tu == 'cliente')
                            <table class="table table-bordered" id="datatable-orders" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Descripción</th>
                                        <th>Número de orden de venta</th>
                                        <th>Cantidad</th>
                                        <th>Precio por unidad</th>
                                        <th>Importe</th>
                                        <th>Seleccionar</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Código</th>
                                        <th>Descripción</th>
                                        <th>Número de orden de venta</th>
                                        <th>Cantidad</th>
                                        <th>Precio por unidad</th>
                                        <th>Importe</th>
                                        <th>Seleccionar</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <div class="form-row">
                                        <?php $i = 1; ?>
                                        @foreach ($proformas as $proforma)
                                        <tr>
                                            <input type="hidden" value="{{ $proforma->id }}" name="proformasIds[]">
                                            <input type="hidden" value="{{ $proforma->product->id }}" name="productsIds[]">
                                            <input type="hidden" value="{{ $proforma->quantity }}" name="productsQuantities[]">

                                            <td>{{ $proforma->product->id }}</td>
                                            <td>{{ $proforma->product->description }}</td>
                                            <td>{{ $proforma->saleorder->order_number }}</td>
                                            <td>{{ $proforma->quantity }}</td>
                                            <td>${{ number_format($proforma->price_unit) }}</td>
                                            <td>${{ number_format($proforma->partial_total) }}</td>
                                            <td>
                                                <input class="form-check-input" type="checkbox" value="{{ $proforma->product->id }}" name="products[]" id="user_products">

                                                <input type="hidden" value="{{ ucfirst($proforma->product->description) }} " name="products[]" id="description_products">

                                                <input type="hidden" value="<?= $i; ?>" name="products[]" id="quantity_products">
                                                <input type="hidden" value="{{ $proforma->partial_total }}" name="products[]" id="price_products">
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                        @endforeach
                                </tbody>
                            </table>
                            @else
                            <table class="table table-bordered" id="datatable-orders" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Descripción</th>
                                        <th>Número de orden de venta</th>
                                        <th>Cantidad</th>
                                        <th>Precio por unidad</th>
                                        <th>Importe</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Código</th>
                                        <th>Descripción</th>
                                        <th>Número de orden de venta</th>
                                        <th>Cantidad</th>
                                        <th>Precio por unidad</th>
                                        <th>Importe</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    <div class="form-row">
                                        <?php $i = 1; ?>
                                        @foreach ($proformas as $proforma)
                                        <tr>
                                            <?php //dd($proforma->product->id); 
                                            ?>
                                            <input type="hidden" value="{{ $proforma->id }}" name="proformasIds[]">
                                            <input type="hidden" value="{{ $proforma->product->id }}" name="productsIds[]">
                                            <input type="hidden" value="{{ $proforma->quantity }}" name="productsQuantities[]">

                                            <td>{{ $proforma->product->id }}</td>
                                            <td>{{ $proforma->product->description }}</td>
                                            <td>{{ $proforma->saleorder->order_number }}</td>
                                            <td>{{ $proforma->quantity }}</td>
                                            <td>${{ number_format($proforma->price_unit) }}</td>
                                            <td>${{ number_format($proforma->partial_total) }}</td>
                                            <input type="hidden" value="{{ $proforma->product->id }}" name="products[]" id="user_products">
                                            <input type="hidden" value="{{ ucfirst($proforma->product->description) }} " name="products[]" id="description_products">
                                            <input type="hidden" value="<?= $i; ?>" name="products[]" id="quantity_products">
                                            <input type="hidden" value="{{ $proforma->partial_total }}" name="products[]" id="price_products">
                                        </tr>
                                        <?php $i++; ?>
                                        @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#exampleModal" onclick="modalData()">Liquidar</button>
                    <button type="button" class="btn btn-secondary mt-3" onclick="window.history.go(-1); return false;">Cancelar</button>

                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Confirmar liquidación</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card-body">
                                        @if($tu == 'cliente')
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="datatable-orders" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Descripción</th>
                                                        <th>Importe total por mercadería</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Descripción</th>
                                                        <th>Importe total por mercadería</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody id="modal_product_items">
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif
                                        @if ($tu == 'cliente')
                                        <div class="table-responsive text-center">
                                            <table class="table table-bordered" id="datatable-orders" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Subtotal</th>
                                                        <th>Comisión en porcentaje</th>
                                                        <th>Comisión</th>
                                                        <th>Seña</th>
                                                        <th>Importe final</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td id="modal_subtotal"></td>
                                                        <td id="modal_commission">
                                                            <input type="number" class="form-control " id="commission_percentage" name="commission_percentage" min="0" max="100" value="0">
                                                        </td>
                                                        <td id="modal_commission_value">$0</td>
                                                        <td id="modal_partial_payment">
                                                            <input type="number" class="form-control " id="partial_payment" name="partial_payment" value="0">
                                                        </td>
                                                        <td id="modal_total"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        @else

                                        <div class="table-responsive text-center">
                                            <table class="table table-bordered" id="datatable-orders" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Subtotal</th>
                                                        <th>Comisión en porcentaje</th>
                                                        <th>Comisión</th>
                                                        <th>Seña</th>
                                                        <th>Importe final</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td id="modal_subtotal"></td>
                                                        <td id="modal_commission">
                                                            <input type="number" class="form-control " id="commission_percentage" name="commission_percentage" min="0" max="100" value="0">
                                                        </td>
                                                        <td id="modal_commission_value">$0</td>
                                                        <td id="modal_partial_payment">
                                                            <input type="number" class="form-control " id="partial_payment" name="partial_payment" value="0">
                                                        </td>
                                                        <td id="modal_total"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <input type="hidden" name="tu" id="tu" value="{{$tu}}">
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Confirmar</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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
    const modal_product_items = document.querySelector('#modal_product_items')
    const products = document.getElementsByName("products[]")
    const type_user = document.querySelector("#tu")

    console.log(type_user.value)

    const commission = document.querySelector('#commission_percentage')
    const partial_payment = document.querySelector('#partial_payment')

    const modal_commission_v = document.querySelector('#modal_commission_value')
    const modal_subtotal = document.querySelector('#modal_subtotal')
    const modal_total = document.querySelector('#modal_total')
    let modal_commission = 0
    let modal_commission_value = 0
    let modal_partial_payment = 0

    commission.addEventListener('blur', (e) => {
        modal_commission = e.target.value
        modalData()
    })

    partial_payment.addEventListener('blur', (e) => {
        modal_partial_payment = e.target.value
        modalData()
    })

    const modalData = (e) => {
        let inputs = ""
        let i = 0
        let subtotal = 0
        let comision = 0
        let partial_payment = 0
        let total = 0

        while (i < products.length) {
            if (type_user.value == 'cliente') {
                let is_checked = products[i].checked
                if (is_checked) {
                    inputs = inputs + '<tr>' +
                        '<td>' + products[i + 1].value + '</td>' +
                        '<td>' + products[i + 3].value + '</td>' +
                        '</tr>';
                    subtotal = parseFloat(subtotal) + parseFloat(products[i + 3].value)

                }
            } else {
                subtotal = parseFloat(subtotal) + parseFloat(products[i + 3].value)
            }
            i = i + 4;
        }

        if (type_user.value == 'cliente') {
            modal_product_items.innerHTML = inputs
        }
        modal_subtotal.innerHTML = "$" + subtotal

        if (modal_commission) {
            modal_commission_value = parseFloat(subtotal) * (modal_commission / 100)
            modal_commission_v.innerText = "$" + modal_commission_value
        }

        if (type_user.value == 'cliente') {
            modal_total.innerHTML = "$" + (parseFloat(subtotal) + parseFloat(modal_commission_value) - parseFloat(modal_partial_payment))
        } else {
            modal_total.innerHTML = "$" + (parseFloat(subtotal) - parseFloat(modal_commission_value) - parseFloat(modal_partial_payment))
        }

    }

    const checkSubmit = () => {
        if (type_user.value == 'cliente') {
            for (let index = 0; index < products.length; index++) {
                if (products[index].checked) {
                    break;
                }
                alert('Para poder continuar y crear la liquidación es necesario seleccionar al menos una mercadería de la lista.')
                return false
            }
        }
        return true
    }
</script>
@endsection()