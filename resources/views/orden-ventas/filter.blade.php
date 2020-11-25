@extends('layouts.app')

@section('title', ' - Filtrar ordenes de venta')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Filtrar ordenes de venta</h1>
</div>

<!-- Content Row -->
<div class="row">

    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Seleccione el tipo de filtro para encontrar la orden de venta, los campos son opcionales. No es necesario completar todos, solo aquellos que necesite.</h6>
            </div>

            <div class="card-body">

                <form class="mb-5" action="{{ route('orden-ventas.filter') }}" autocomplete="off">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="date-start">Fecha de inicio</label>
                            <input type="date" class="form-control" id="date-start" name="date_start" require>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date-end">Fecha de fin</label>
                            <input type="date" class="form-control" id="date-end" name="date_end" require>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Nombre remitente</label>
                            <input type="text" class="form-control" id="name" name="name" require>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">Apellido remitente</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" require>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Filtrar</button>

                </form>

                @if (count($orders) > 0)
                <div class="card-header py-3 mb-4 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Resultados de búsqueda</h6>
                </div>

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
                @endif
            </div>
        </div>

    </div>

</div>

@endsection()