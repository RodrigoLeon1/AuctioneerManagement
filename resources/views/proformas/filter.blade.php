@extends('layouts.app')

@section('title', ' - Filtrar proformas')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Filtrar proformas</h1>
</div>

<!-- Content Row -->
<div class="row">

    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Seleccione el tipo de filtro para encontrar la proforma. <br>Si solo desea buscar las proformas que se hicieron en determinada fecha de remate, solo complete el primer campo, es decir, <strong>Fecha remate de inicio</strong>.</h6>
            </div>

            <div class="card-body">

                <form class="mb-5" action="{{ route('proformas.filter') }}" autocomplete="off">

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="date-start">Fecha remate de inicio</label>
                            <input type="date" class="form-control" id="date-start" name="date_start" require>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="date-end">Fecha remate de fin</label>
                            <input type="date" class="form-control" id="date-end" name="date_end" require>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="date-end">Codigo de producto</label>
                            <input type="number" class="form-control" id="product_code" name="product_code" require>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3"> <i class="fas fa-search"></i> Filtrar</button>

                </form>

                @if (count($invoices) > 0)
                <div class="card-header py-3 mb-4 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Resultados de búsqueda -
                        @if ($from)                        
                            <strong>{{ date("d/m/Y", strtotime($from)) }}</strong>
                            {{ $to ? 'al' : '' }}
                            <strong>{{ $to ? date("d/m/Y", strtotime($to)) : '' }}</strong>
                        @endif
                    </h6>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable-invoices" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Fecha remate</th>
                                <th>Importe total</th>
                                <th>Mercadería</th>
                                <th>Comprador</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Fecha remate</th>
                                <th>Importe total</th>
                                <th>Mercadería</th>
                                <th>Comprador</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($invoices as $invoice)
                            <tr>
                                <td> {{ date("d/m/Y", strtotime($invoice->date_remate)) }}</td>
                                <td>${{ number_format($invoice->total) }}</td>
                                <td>{{ $invoice->product->description }}</td>
                                <td>
                                    {{ $invoice->user ? $invoice->user->name . ' ' . $invoice->user->lastname : 'Comprador eliminado' }}
                                </td>
                                <td>
                                    <a href="{{ route('proformas.show', $invoice->id) }}" class="btn btn-info btn-circle">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <a href="{{ route('proformas.pdf', $invoice->id) }}" class="btn btn-success btn-circle">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <form action="{{ route('proformas.destroy', $invoice->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('¿Desea eliminar este registro?');">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-circle">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
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