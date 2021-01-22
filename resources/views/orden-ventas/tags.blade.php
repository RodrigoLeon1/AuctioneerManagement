<!DOCTYPE html>
<html lang="es">

<head>
    <title>Orden de venta #{{ $order->order_number }} Etiquetas</title>
</head>

<style>
    .logo-container__info {
        float: left;
    }

    .logo-container__dates {
        float: right;
    }

    .tag-text{
        font-size: 20px;
    }

    /*  */
    table {
        font-family: arial, sans-serif;
        width: 100%;
    }

    td,
    th {
        background: white;
        border: 1px solid #5c5c5c;
        text-align: center;
        padding: 1px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>


<body>
    <div>
        @foreach ($order->products as $product)
        <table>
            
                <tr>
                    @for ($i = 0; $i < $product->pivot->quantity_tags; $i++)
                        <td>
                            <h1 class="tag-text">{{$product->id}}</h1>
                            <br>
                            <h1 class="tag-text">{{$product->description}}<h1>
                        </td>
                    @endfor
                </tr>    
            
        </table>
        @endforeach
        <br>
    </div>
</body>

</html>