<!DOCTYPE html>
<html lang="es">

<head>
    <title>Orden de venta #{{ $order->order_number }}</title>
</head>

<style>
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
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>

<body>
    <!--  -->
    <div>
        <div class="logo-container">
            <div class="logo-container__info">
                ### REMATES ISI ### <br>
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
        <br>
        <p>
            Datos generales de la orden de venta #{{ $order->order_number }}
        </p>
        <table>
            <tr>
                <th>Fecha</th>
                <th>Fecha de pago</th>
                <th>Remito</th>
                <th>Número de orden</th>
                <th>Remitente</th>
            </tr>
            <tr>
                <td>{{ date('d/m/Y', strtotime($order->date_set)) }}</td>
                <td>{{ date('d/m/Y', strtotime($order->date_payment)) }}</td>
                <td>{{ $order->remito }}</td>
                <td>{{ $order->order_number }}</td>
                <td>{{ ucfirst($order->user->name) }} {{ ucfirst($order->user->lastname) }}</td>
            </tr>
        </table>
        <br>
        <p>
            A continuación podrá observar el listado de las mercaderías que se dieron de alta en la orden de venta.
        </p>
        <table>
            <tr>
                <th>Descripción</th>
                <th>Cantidad total</th>
                <th>Tasac</th>
                <th>Categoría</th>
            </tr>
            @foreach ($order->products as $product)
            <tr>
                <td>{{ ucfirst($product->description) }}</td>
                <td>{{ $product->pivot->quantity }}</td>
                <td>{{ $order->tasac }}</td>
                @forelse ($product->categories as $category)
                <td>{{ $category->description }}</td>
                @empty
                <td> Sin categoría </td>
                @endforelse
            </tr>
            @endforeach
        </table>
    </div>

    <!--  -->
    <br><br><br><br><br>
    <div>
        <div class="logo-container">
            <div class="logo-container__info">
                ### REMATES ISI ### <br>
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
        <br>
        <p>
            Datos generales de la orden de venta #{{ $order->order_number }}
        </p>
        <table>
            <tr>
                <th>Fecha</th>
                <th>Fecha de pago</th>
                <th>Remito</th>
                <th>Número de orden</th>
                <th>Remitente</th>
            </tr>
            <tr>
                <td>{{ date('d/m/Y', strtotime($order->date_set)) }}</td>
                <td>{{ date('d/m/Y', strtotime($order->date_payment)) }}</td>
                <td>{{ $order->remito }}</td>
                <td>{{ $order->order_number }}</td>
                <td>{{ ucfirst($order->user->name) }} {{ ucfirst($order->user->lastname) }}</td>
            </tr>
        </table>
        <br>
        <p>
            A continuación podrá observar el listado de las mercaderías que se dieron de alta en la orden de venta.
        </p>
        <table>
            <tr>
                <th>Descripción</th>
                <th>Cantidad total</th>
                <th>Tasac</th>
                <th>Categoría</th>
            </tr>
            @foreach ($order->products as $product)
            <tr>
                <td>{{ ucfirst($product->description) }}</td>
                <td>{{ $product->pivot->quantity }}</td>
                <td>{{ $order->tasac }}</td>
                @forelse ($product->categories as $category)
                <td>{{ $category->description }}</td>
                @empty
                <td> Sin categoría </td>
                @endforelse
            </tr>
            @endforeach
        </table>
    </div>

</body>

</html>