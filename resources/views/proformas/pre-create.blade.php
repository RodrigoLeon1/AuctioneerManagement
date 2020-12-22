@extends('layouts.app')

@section('title', ' - Crear proforma')

@section('content')
<link href="{{ asset('vendor/jquery-ui-1.12.1/jquery-ui.min.css') }}" rel="stylesheet" type="text/css">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Crear proforma</h1>
</div>

@if (session('error-store'))
<div class="alert alert-warning" role="alert">
    <h4 class="alert-heading">
        {{ session('error-store') }}
    </h4>
</div>
@endif

<!-- Content Row -->
<div class="row">

    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    A continuación podrá observar aquellas órdenes de venta, que tienen mercadería disponible para vender.
                </h6>
            </div>

            <div class="card-body">

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="container">
                    <div class="row">
                        @forelse ($orders as $order)
                        <div class="card col-xl-12 col-lg-12 mb-4">
                            <div class="card-header">
                                <strong>Número de orden:</strong> {{ $order->order_number }}
                            </div>
                            <div class="card-body">
                                <ul>
                                    <li>
                                        <strong>Fecha:</strong> {{ $order->date_set }}
                                    </li>
                                    <li>
                                        <strong>Remito:</strong> {{ $order->remito }}
                                    </li>
                                    <li>
                                        <strong>Remitente:</strong> {{ $order->user->name }} {{ $order->user->lastname }}
                                    </li>
                                    <li>
                                        <strong>Más información:</strong>
                                        <a href="{{ route('orden-ventas.show', $order->id) }}" target="_blank">Ver más</a>
                                    </li>
                                </ul>
                                <p class="mt-3">
                                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse{{ $order->id }}" aria-expanded="false" aria-controls="collapse{{ $order->id }}">
                                        Seleccionar mercadería
                                    </button>
                                </p>
                                <div class="collapse" id="collapse{{ $order->id }}">
                                    <div class="card card-body">
                                        <span class="mb-2">Clickee en la mercadería deseada:</span>
                                        <ul>
                                            @foreach ($order->products as $product)
                                            @if ( !$product->pivot->quantity_remaining )
                                            <li class="mb-3">
                                                <a class="btn btn-warning btn-icon-split">
                                                    <span class="text">'{{ $product->description }}' no tiene unidades disponibles para vender.</span>
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            @else
                                            <li class="mb-3">
                                                <a href="{{ route('proformas.create', ['orden' => $order->id, 'mercaderia' => $product->id]) }}" class="btn btn-success btn-icon-split">
                                                    <span class="text">{{ $product->id }} - {{ $product->description }}</span>
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-arrow-right"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <strong>
                            No se encontraron ordenes de ventas registradas.
                            Click <a href="{{ route('orden-ventas.create') }}">'aqui'</a> para crear una Orden de venta.
                        </strong>
                        @endforelse
                    </div>
                </div>
                {{ $orders->links() }}
            </div>
        </div>
    </div>

</div>

@endsection()