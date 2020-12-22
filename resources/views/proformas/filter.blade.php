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
                <h6 class="m-0 font-weight-bold text-primary">Seleccione el tipo de filtro para encontrar la proforma.</h6>
            </div>

            <div class="card-body">

                <form class="mb-5" action="{{ route('proformas.filter') }}" autocomplete="off">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="date-start">Fecha remate de inicio</label>
                            <input type="date" class="form-control" id="date-start" name="date_start" require>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date-end">Fecha remate de fin</label>
                            <input type="date" class="form-control" id="date-end" name="date_end" require>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3"> <i class="fas fa-search"></i> Filtrar</button>

                </form>

                @if (count($invoices) > 0)
                <div class="card-header py-3 mb-4 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Resultados de búsqueda -
                        <strong>{{ date("d/m/Y", strtotime($from)) }}</strong>
                        al
                        <strong>{{ date("d/m/Y", strtotime($to)) }}</strong>
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
                                <td>{{ $invoice->date_remate }}</td>
                                <td>{{ $invoice->total }}</td>
                                <td>{{ $invoice->product->description }}</td>
                                <td>{{ $invoice->user->name }} {{ $invoice->user->lastname }}</td>
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