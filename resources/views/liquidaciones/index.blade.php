@extends('layouts.app')

@section('title', ' - Listar liquidaciones')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Listar liquidaciones</h1>
</div>

@if (session('success-store'))
<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">
        {{ session('success-store') }}
    </h4>
</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            A continuación podrá observar el listado de las liquidaciones creadas y acceder a la ficha de cada una
        </h6>
    </div>
    <div class="card-body">
        <a href="{{ route('liquidaciones.pre-create', ['tu' => 'cliente'])  }}" class="btn btn-success btn-icon-split mb-4">
            <span class="text">Crear liquidación cliente</span>
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
        </a>
        <a href="{{ route('liquidaciones.pre-create', ['tu' => 'remitente']) }}" class="btn btn-success btn-icon-split mb-4" style="background-color: #218c65;">
            <span class="text">Crear liquidación remitente</span>
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
        </a>
        <div class="table-responsive">
            <table class="table table-bordered" id="datatable-orders" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo de liquidación</th>
                        <th>Usuario</th>
                        <th>Importe final</th>
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
                        <td>${{ number_format($invoice->total) }}</td>
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
            {{ $invoices->links() }}
        </div>
    </div>
</div>
@endsection()