@extends('layouts.app')

@section('title', ' - Listar proformas')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Listar proformas</h1>
</div>

@if (session('success-store'))
<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">
        {{ session('success-store') }}
    </h4>
</div>
@endif

@if (session('success-destroy'))
<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">
        {{ session('success-destroy') }}
    </h4>
</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            A continuación podrá observar el listado de las proformas creadas y acceder a la ficha de cada una.
        </h6>
    </div>
    <div class="card-body">
        <a href="{{ route('proformas.pre-create') }}" class="btn btn-success btn-icon-split mb-4">
            <span class="text">Crear proforma</span>
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
        </a>
        <div class="table-responsive">
            <table class="table table-bordered" id="datatable-orders" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Fecha remate</th>
                        <th>Importe total</th>
                        <th>Mercadería</th>
                        <th>Cantidad</th>
                        <th>Comprador</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Fecha remate</th>
                        <th>Importe total</th>
                        <th>Mercadería</th>
                        <th>Cantidad</th>
                        <th>Comprador</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                    @forelse($invoices as $invoice)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($invoice->date_remate)) }}</td>
                        <td> ${{ $invoice->total }}</td>
                        <td>{{ $invoice->product->description }}</td>
                        <td>{{ $invoice->quantity }}</td>
                        <td>{{ $invoice->user->name }} {{ $invoice->user->lastname }}</td>
                        <td>
                            <a href="{{ route('proformas.show', $invoice->id) }}" class="btn btn-info btn-circle">
                                <i class="fas fa-info-circle"></i>
                            </a>
                            <a href="{{ route('proformas.pdf', $invoice->id) }}" target="_blank" class="btn btn-success btn-circle">
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
                    @empty
                    <tr>
                        <td colspan="6">No se encontraron proformas registradas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection()