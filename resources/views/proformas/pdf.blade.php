<!DOCTYPE html>
<html lang="es">

<head>
    <title>Proforma #{{ $invoice->id }}</title>
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
    <div>
        <div class="logo-container">
            <div class="logo-container__info">
                ### REMATES ISE ### <br>
                Rodriguez Peña 6342 <br>
                7600 - Mar del Plata
            </div>
            <div class="logo-container__dates">
                Fecha: {{ date('d/m/Y') }} <br>
                Proforma #{{ $invoice->id }}
            </div>
        </div>

        <br><br><br>
        <hr>
        <br>
        <p>
            Datos generales de la proforma #{{ $invoice->id }}
        </p>
        <table>
            <tr>
                <th>Fecha de remate</th>
                <th>Fecha de entrega</th>
                <th>Número de orden</th>
                <th>Comprador</th>
            </tr>
            <tr>
                <td>{{ date('d/m/Y', strtotime($invoice->date_remate)) }}</td>
                <td>{{ date('d/m/Y', strtotime($invoice->date_delivery)) }}</td>
                <td>{{ $invoice->saleorder->order_number }}</td>
                <td>{{ $invoice->user->name }} {{ $invoice->user->lastname }}</td>
            </tr>
        </table>
        <br>
        <p>
            Información sobre la mercadería vendida y su precio final.
        </p>
        <table>
            <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio por unidad</th>
                <th>Importe</th>
            </tr>
            <tr>
                <td>{{ $invoice->product->id }}</td>
                <td>{{ $invoice->product->description }}</td>
                <td>{{ $invoice->quantity }}</td>
                <td>${{ $invoice->price_unit }}</td>
                <td>${{ $invoice->partial_total }}</td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <th>Comisión</th>
                <th>Seña</th>
                <th>Importe total y final</th>
            </tr>
            <tr>
                <td>${{ $invoice->commission }}</td>
                <td>${{ $invoice->partial_payment }}</td>
                <td style="text-align: center;"> <strong style="font-size: 30px;"> ${{ $invoice->total }}</strong></td>
            </tr>
        </table>
    </div>
</body>

</html>