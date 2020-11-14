@extends('layouts.app')

@section('title', ' - Listar ordenes de venta')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Listar órdenes de venta</h1>
</div>

@if (app('request')->input('success') == 1)
<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">Su orden de venta ha sido creada de manera exitosa.</h4>
</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            A continuación podrá observar el listado de las órdenes de ventas creadas y acceder a la ficha de cada una.
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="datatable-orders" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Remito</th>
                        <th>Número de orden</th>
                        <th>Remitente</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Fecha</th>
                        <th>Remito</th>
                        <th>Número de orden</th>
                        <th>Remitente</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td> {{ $order->date_set }} </td>
                        <td> {{ $order->remito }} </td>
                        <td> {{ $order->order_number }} </td>
                        <td> {{ $order->user->name }} {{ $order->user->lastname }} </td>
                        <td>
                            <a href="{{ route('orden-ventas.show', $order->id) }}" class="btn btn-info btn-circle">
                                <i class="fas fa-info-circle"></i>
                            </a>
                            <a href="{{ route('orden-ventas.pdf', $order->id) }}" class="btn btn-success btn-circle">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection()