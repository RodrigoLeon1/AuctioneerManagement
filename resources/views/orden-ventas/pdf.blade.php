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
                <td>
                    {{ $order->user ? ucwords($order->user->name . ' ' . $order->user->lastname) : 'Remitente eliminado' }}
                </td>
            </tr>
        </table>
        <br>
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
            <p>
                <strong>CONDICIONES DE ESTA ORDEN DE VENTA</strong>

                LA EMPRESA recibe las mercaderias en consignacion, por un plazo mínimo de 30 dias, serán puestas a la venta dentro de los diez días de la fecha recibida si no hubiera comprador, el remitente deberá retirarlas a su cargo. Si se le hubiera puesto base de venta, deberá abonar el 20% sobre esta base en concepto de depósito y gastos.
                LA EMPRESA, no asume responsabilidad por roturas, deterioro o robo de la mercadería que se le entregue para la venta. Salvo que el remitente pague por adelantado el 5% por ciento del valor de la tasación en concepto de seguro teniendo una cobertura por sesenta días del presente recibo.
                Cuando por cualquier caso(rotura-robo)no se pudiera vender la mercadería ni reintegrarla al remitente y éste hubiera abonado seguro respectivo, LA EMPRESA, la liquidará como vendida al 70% del valor de tasación, a los treinta de solicitada la liquidación.
                No habiendo contratado seguro o venció el plazo el remitente no tendrá derecho a reclamo alguno.
                La tasación no constituye base de venta, solo se indica a los fines del seguro a contratar, asimismo se pondrá a la venta al mejor precio posible considerado por LA EMPRESA, y el remitente acepta esta condición.
                Los importes que resulten de las ventas ordenadas por el presente recibo, serán liquidados a los remitentes previa deducción de la comisión pactada del 10% más 10% de gastos de depósito. Total 20%.
                El día del pago será el primer jueves de 9 a 12 hs de cada mes, posterior al mes de recibida la mercadería, luego de este primer jueves podrá presentarse para cobros y consultas por las ventas, todos los jueves en el horario mencionado de 9 a 12 hs.
                LA EMPRESA atenderá la presencia del remitente para las consultas y cobro de liquidaciones, solamente los jueves de 9 a 12 hs.
                Es indispensable presentar el remito que justifique la propiedad de los bienes a vender y la identidad del titular que figure en el presente recibo.
                Si no pudiera concurrir el titular podrá autorizar por escrito, y presentado el recibo y liquidaciones previas, si existieran.
                Las liquidaciones no cobradas dentro de los 180 días corridos, de la venta de los objetos en cuestión, se percibirán a favor de LA EMPRESA.
                LA EMPRESA, no abonará ninguna liquidación si no es presentado en el presente recibo, En caso de pérdida del mismo, deberá presentarse, siempre los jueves de 9 a 12 hs, y solicitar la liquidación, la que será realizada dentro de los 15 días siguientes, para que LA EMPRESA pueda constatar si ya hubiera sido cobrado o no, todo o algun articulo de los que figure en el presente recibo.
                LA EMPRESA, queda autorizada a adjudicarse las mercaderías que no se hayan podido vender a un precio igual al adeudado por anticipos, fletes o gastos.
                CLÁUSULA ESPECIAL para mercaderías con base; esta base se fija por treinta días de recibidos los bienes a vender, posteriormente se reducirá semanalmente hasta lograr su venta.
                El remitente reconoce y acepta las condiciones propuestas por LA EMPRESA, la que realizará los mayores esfuerzos para lograr la mejor venta posible.
                LA EMPRESA, no está obligada a dar aviso de las ventas realizadas.

                <strong>IMPORTANTE:</strong> Dia de pago e informes Jueves de 9 a 12 hs.

                <strong>IMPORTANTE: </strong>Las consultas deben ser personalmente y Sin excepción debe presentar este remito
            </p>
        </div>
    </div>
</body>

</html>