@extends('layouts.app')

@section('title', ' - Listar categoría')

@section('content')

@isset ($category)
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Información sobre categoría </h1>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            A continuación podrá observar la información completa de la categoría.
        </h6>
    </div>
    <div class="card-body">

        <h4>
            <strong>Datos generales</strong>
        </h4>
        <div class="form-group row">
            <label for="staticDate" class="col-sm-2 col-form-label">Descripción</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticDate" value="{{ $category->description }}">
            </div>
        </div>

        <hr>

        <h4>
            <strong>Mercadería relacionada</strong>
        </h4>
        <ul>
            @forelse ($category->products as $product)
            <li>{{ $product->description }} - <a href="{{ route('productos.show', $product->id) }}">Más información</a></li>
            @empty
            <li>No se encontro mercadería para la categoría seleccionada.</li>
            @endforelse
        </ul>

    </div>
</div>
@else
<div class="container">
    <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">
            <strong>La categoría seleccionada no existe.</strong>
        </h4>
        <p>Probablemente el ID de la categoría no es valido. Vuelva al menu 'Listar categorías' y seleccione nuevamente.</p>
        <hr>
        <p class="mb-0">
            <a href="{{ route('categorias.index') }}" class="alert-link">Volver a 'Listar categorías'.</a>
        </p>
    </div>
</div>
@endisset

@endsection()