<!DOCTYPE html>
<html lang="es">

<head>
    <title>Orden de venta #{{ $order->order_number }}</title>
</head>

<style>
    body {
        font-size: .7rem;
    }

    .logo-container__info {
        float: left;
    }

    .logo-container__dates {
        float: right;
    }

    /*  */
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 2px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>

<body>
    <div>
        <div class="logo-container">
            <div class="logo-container__info">
                ### REMATES ISE ### <br>
                Rodriguez Peña 6342 <br>
                7600 - Mar del Plata
            </div>
            <div class="logo-container__dates">
                Fecha: {{ date('d/m/Y') }} <br>
                Orden de venta #{{ $order->order_number }}
            </div>
        </div>

        <br><br><br>
        <hr>
        <table>
            <tr>
                <th>Fecha</th>
                <th>Fecha de pago</th>
                <th>Remito</th>
                <th>Número de orden</th>
            </tr>
            <tr>
                <td>{{ date('d/m/Y', strtotime($order->date_set)) }}</td>
                <td>{{ date('d/m/Y', strtotime($order->date_payment)) }}</td>
                <td>{{ $order->remito }}</td>
                <td>{{ $order->order_number }}</td>
            </tr>
        </table>
        <table>
            <tr>
                <th>Remitente</th>
                <th>Domicilio</th>
                <th>Ciudad</th>
                <th>Teléfono</th>
                <th>C. Postal</th>
                <th>DNI</th>
                <th>CUIT</th>
            </tr>
            <tr>
                <td>
                    {{ $order->user ? ucwords($order->user->name . ' ' . $order->user->lastname) : 'Remitente eliminado' }}
                </td>
                <td>{{ ucwords($order->user->address) }}</td>
                <td>{{ ucwords($order->user->city) }}</td>
                <td>{{ $order->user->phone }} </td>
                <td>{{ $order->user->postal_code }} </td>
                <td>{{ $order->user->dni }} </td>
                <td>{{ $order->user->cuit }} </td>
            </tr>
        </table>

        <p>
            A continuación podrá observar el listado de las mercaderías que se dieron de alta en la orden de venta.
        </p>
        <table>
            <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Cantidad total</th>
            </tr>
            @foreach ($order->products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ ucfirst($product->description) }}</td>
                <td>{{ $product->pivot->quantity }}</td>
            </tr>
            @endforeach
        </table>

        <div>
            <br>
            <strong>Acepto las condiciones detalladas al dorso:</strong>
            <span>..........................................................................</span><br>
            <strong>Fecha de pago UNICAMENTE: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Firma</strong><br>
            <p>
                Recibimos de acuerdo a las condiciones que se especifican en la presente Orden de Venta, para rematar o vender particularmente las mercaderías que se detallan a continuación, propiedad del remitente que se indica al pie. <strong>EL PRESENTE RECIBO SERÁ EXIGIDO para abonar la liquidación de las ventas, no admitiendose sin este recibo. ESTE RECIBO ES INTRANSFERIBLE, RECOMENDAMOS SU CONSERVACIÓN.</strong>
            </p>
        </div>

    </div>
    <br><br>

    <div>
        <div class="logo-container">
            <div class="logo-container__info">
                ### REMATES ISE ### <br>
                Rodriguez Peña 6342 <br>
                7600 - Mar del Plata
            </div>
            <div class="logo-container__dates">
                Fecha: {{ date('d/m/Y') }} <br>
                Orden de venta #{{ $order->order_number }}
            </div>
        </div>

        <br><br><br>
        <hr>
        <table>
            <tr>
                <th>Fecha</th>
                <th>Fecha de pago</th>
                <th>Remito</th>
                <th>Número de orden</th>
            </tr>
            <tr>
                <td>{{ date('d/m/Y', strtotime($order->date_set)) }}</td>
                <td>{{ date('d/m/Y', strtotime($order->date_payment)) }}</td>
                <td>{{ $order->remito }}</td>
                <td>{{ $order->order_number }}</td>
            </tr>
        </table>
        <table>
            <tr>
                <th>Remitente</th>
                <th>Domicilio</th>
                <th>Ciudad</th>
                <th>Teléfono</th>
                <th>C. Postal</th>
                <th>DNI</th>
                <th>CUIT</th>
            </tr>
            <tr>
                <td>
                    {{ $order->user ? ucwords($order->user->name . ' ' . $order->user->lastname) : 'Remitente eliminado' }}
                </td>
                <td>{{ ucwords($order->user->address) }}</td>
                <td>{{ ucwords($order->user->city) }}</td>
                <td>{{ $order->user->phone }} </td>
                <td>{{ $order->user->postal_code }} </td>
                <td>{{ $order->user->dni }} </td>
                <td>{{ $order->user->cuit }} </td>
            </tr>
        </table>

        <p>
            A continuación podrá observar el listado de las mercaderías que se dieron de alta en la orden de venta.
        </p>
        <table>
            <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Cantidad total</th>
            </tr>
            @foreach ($order->products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ ucfirst($product->description) }}</td>
                <td>{{ $product->pivot->quantity }}</td>
            </tr>
            @endforeach
        </table>

        <div>
            <br>
            <strong>Acepto las condiciones detalladas al dorso:</strong>
            <span>..........................................................................</span><br>
            <strong>Fecha de pago UNICAMENTE: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Firma</strong><br>
            <p>
                Recibimos de acuerdo a las condiciones que se especifican en la presente Orden de Venta, para rematar o vender particularmente las mercaderías que se detallan a continuación, propiedad del remitente que se indica al pie. <strong>EL PRESENTE RECIBO SERÁ EXIGIDO para abonar la liquidación de las ventas, no admitiendose sin este recibo. ESTE RECIBO ES INTRANSFERIBLE, RECOMENDAMOS SU CONSERVACIÓN.</strong>
            </p>
        </div>

    </div>
</body>

</html>