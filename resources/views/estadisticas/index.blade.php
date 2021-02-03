@extends('layouts.app')

@section('title', ' - Consultar ganancias')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Consultar ganancias</h1>
</div>

<!-- Content Row -->
<div class="row">

    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    Seleccione el rango de fechas en las que desea consultar las ganancias.
                    <br>Si solo desea buscar las ganancias que se hicieron en determinada fecha, solo complete el primer campo, es decir, <strong>Fecha de inicio</strong>.
                </h6>
            </div>

            <div class="card-body">

                <form class="mb-5" action="{{ route('estadisticas.index') }}" autocomplete="off">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="from">Fecha de inicio</label>
                            <input type="date" class="form-control" id="from" name="from">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="to">Fecha de fin</label>
                            <input type="date" class="form-control" id="to" name="to">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="type">Tipo de liquidación</label>
                            <select class="form-control" name="type" id="type">
                                <option value="liquidado">Liquidado</option>
                                <option value="no_liquidado">No liquidado</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3"> <i class="fas fa-search"></i> Filtrar</button>
                </form>

                @if ($invoices !== null && count($invoices) > 0)
                <div class="card-header py-3 mb-4 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Resultados de búsqueda -
                        <strong>{{ date("d/m/Y", strtotime($from)) }}</strong>
                        al
                        <strong>{{ date("d/m/Y", strtotime($to)) }}</strong>
                    </h6>
                </div>

                <div class="col-xl-12 col-md-12 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Ganancias total (Sin COMISIÓN)</div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">${{ number_format($total) }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-md-12 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Cantidad vendida</div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ number_format($quantity) }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-list-ol fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-md-12 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Ganancias por comisión</div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">${{ number_format($commission) }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable-orders" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Tipo de liquidación</th>
                                <th>Usuario</th>
                                <th>Importe final</th>
                                <th>Comisión</th>
                                <th>Mercadería</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Fecha</th>
                                <th>Tipo de liquidación</th>
                                <th>Usuario</th>
                                <th>Importe final</th>
                                <th>Comisión</th>
                                <th>Mercadería</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($invoices as $invoice)
                            <tr>
                                <td>{{ date('d/m/Y', strtotime($invoice->created_at)) }}</td>
                                <td>{{ ucfirst($invoice->type_invoice) }}</td>
                                <td>
                                    {{ $invoice->user ? $invoice->user->name . ' ' . $invoice->user->lastname : 'Usuario eliminado' }}
                                </td>
                                <td>${{ number_format($invoice->subtotal) }}</td>
                                <td>${{ number_format($invoice->commission) }}</td>
                                <td>
                                    <ul>
                                        @foreach ($invoice->products as $product)
                                        <li>
                                            {{ $product->description }} ( {{ $product->pivot->quantity}} unidades )
                                        </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <a href="{{ route('liquidaciones.show', $invoice->id) }}" class="btn btn-info btn-circle">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <a href="{{ route('liquidaciones.pdf', $invoice->id) }}" target="_blank" class="btn btn-success btn-circle">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">No se encontraron liquidaciones registradas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @elseif ($invoicesProforma !== null && count($invoicesProforma) > 0)
                <div class="card-header py-3 mb-4 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Resultados de búsqueda -
                        <strong>{{ date("d/m/Y", strtotime($from)) }}</strong>
                        al
                        <strong>{{ date("d/m/Y", strtotime($to)) }}</strong>
                    </h6>
                </div>

                <div class="col-xl-12 col-md-12 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Ganancias total</div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">${{ number_format($total) }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-md-12 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Cantidad vendida</div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ number_format($quantity) }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-list-ol fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-md-12 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Ganancias por comisión</div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">${{ number_format($commission) }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable-orders" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Tipo de liquidación</th>
                                <th>Usuario</th>
                                <th>Importe final</th>
                                <th>Comisión</th>
                                <th>Mercadería</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Fecha</th>
                                <th>Tipo de liquidación</th>
                                <th>Usuario</th>
                                <th>Importe final</th>
                                <th>Comisión</th>
                                <th>Mercadería</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($invoicesProforma as $invoice)
                            <tr>
                                <td>{{ date('d/m/Y', strtotime($invoice->created_at)) }}</td>
                                <td>Sin liquidar</td>
                                <td>
                                    {{ $invoice->user ? $invoice->user->name . ' ' . $invoice->user->lastname : 'Usuario eliminado' }}
                                </td>
                                <td>${{ number_format($invoice->partial_total) }}</td>
                                <td>${{ number_format($invoice->commission_value) }}</td>
                                <td>{{ $invoice->product->description }}</td>
                                <td>
                                    <a href="{{ route('proformas.show', $invoice->id) }}" class="btn btn-info btn-circle">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <a href="{{ route('proformas.pdf', $invoice->id) }}" target="_blank" class="btn btn-success btn-circle">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">No se encontraron liquidaciones registradas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection()