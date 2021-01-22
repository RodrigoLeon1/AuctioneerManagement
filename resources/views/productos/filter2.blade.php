@extends('layouts.app')

@section('title', ' - Mercaderías')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Mercaderías - {{ ucfirst(str_replace('-',' ',$query)) }}</h1>
</div>

<!-- Content Row -->
<div class="row">

    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">A continuación podrá observar el listado de las mercaderías vendidas o no vendidas, según su elección.</h6>
            </div>

            <div class="card-body">
                @if ($query == 'vendidas')
                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable-orders" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Fecha de creación</th>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Comprador</th>
                                <th>Remitente</th>
                                <th>Importe final</th>
                                <th>Liquidación</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Fecha de creación</th>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Comprador</th>
                                <th>Remitente</th>
                                <th>Importe final</th>
                                <th>Liquidación</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($products as $product)
                            @foreach ($product->invoices as $invoice)
                            @if ($invoice->type_invoice === 'cliente')
                            <tr>
                                <td> {{ date("d/m/Y", strtotime($product->created_at)) }}</td>
                                <td> {{ $product->id }} </td>
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
                                    {{ $invoice->user ? ucwords($invoice->user->name . ' ' . $invoice->user->lastname) : 'Remitente eliminado' }}
                                </td>
                                <td>
                                    @foreach ($product->saleorder as $saleorder)
                                    {{ $saleorder->user ? ucwords($saleorder->user->name . ' ' . $saleorder->user->lastname) : 'Remitente eliminado' }}
                                    @endforeach
                                </td>
                                <td>${{$invoice->total}}</td>
                                <td>
                                    <a href="{{ route('liquidaciones.show', $invoice->id) }}" class="btn btn-info btn-circle">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                            @empty
                            <tr>
                                <td colspan="7">No se han encontrado mercaderías vendidas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $products->links() }}
                </div>
                @elseif ($query == 'no-vendidas')
                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable-orders" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Fecha de creación</th>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Categoría</th>
                                <th>Remitente</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Fecha de creación</th>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Categoría</th>
                                <th>Remitente</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($products as $product)
                            <tr>
                                <td>{{ date('d/m/Y', strtotime($product->created_at)) }}</td>
                                <td> {{ $product->id }} </td>
                                <td> {{ $product->description }} </td>
                                <td>
                                    @forelse ($product->categories as $category)
                                    {{ $category->description ? $category->description : 'Categoría eliminada' }}
                                    @empty
                                    Categoría eliminada
                                    @endforelse
                                </td>
                                <td>
                                    @foreach ($product->saleorder as $saleorder)
                                    {{ $saleorder->user ? ucwords($saleorder->user->name . ' ' . $saleorder->user->lastname) : 'Remitente eliminado' }}
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('productos.show', $product->id) }}" class="btn btn-info btn-circle">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <a href="{{ route('productos.edit', $product->id) }}" class="btn btn-warning btn-circle">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">No se han encontrado mercaderías no vendidas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $products->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection()