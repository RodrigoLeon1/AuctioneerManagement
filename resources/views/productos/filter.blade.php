<script>
    function show_category() {
        document.getElementById('category-search').style.display = "flex";
        document.getElementById('cd-search').style.display = "none";
    }

    function show_description() {
        document.getElementById('category-search').style.display = "none";
        document.getElementById('cd-search').style.display = "flex";
    }

    function show_code() {
        document.getElementById('category-search').style.display = "none";
        document.getElementById('cd-search').style.display = "flex";
    }
</script>

@extends('layouts.app')

@section('title', ' - Filtrar mercaderías')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Filtrar mercaderías</h1>
</div>

<!-- Content Row -->
<div class="row">

    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Seleccione el tipo de filtro para encontrar la mercadería</h6>
            </div>

            <div class="card-body">

                <form class="mb-5" action="{{ route('productos.filter') }}" autocomplete="off">

                    <div class="form-row justify-content-center">
                        <div class="col-md-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input radio-name" type="radio" name="type_search" id="type_search" value="code" onclick="show_code();">
                                <label class="form-check-label" for="type_search">
                                    Codigo
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input radio-dni" type="radio" name="type_search" id="type_search2" value="description" onclick="show_description();">
                                <label class="form-check-label" for="type_search2">
                                    Descripcion
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input radio-cuit" type="radio" name="type_search" id="type_search3" value="category" onclick="show_category();">
                                <label class="form-check-label" for="type_search3">
                                    Categoria
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row justify-content-md-center" id="cd-search" style="display:none;">
                        <div class="form-group col-md-4 mt-5">
                            <input type="search" class="form-control" id="search" name="search">
                        </div>
                        <div class="form-group col-md-2 mt-5">
                            <button type="submit" class="btn btn-primary"> <i class="fas fa-search"></i> Filtrar</button>
                        </div>
                    </div>

                    <div class="form-group justify-content-md-center" id="category-search" style="display:none;">
                        <div class="form-group col-md-4 mt-5">
                            <select class="form-control" name="category" id="category">
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}"> {{ $category->description }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2 mt-5">
                            <button type="submit" class="btn btn-primary"> <i class="fas fa-search"></i> Filtrar</button>
                        </div>
                    </div>
                </form>

                @if (count($products) > 0)
                <div class="card-header py-3 mb-4 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Resultados de búsqueda
                    </h6>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable-orders" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Fecha de creación</th>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Categoría</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Fecha de creación</th>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Categoría</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td> {{ date("d/m/Y", strtotime($product->created_at)) }}</td>
                                <td> {{ $product->id }} </td>
                                <td> {{ $product->description }} </td>
                                <td>
                                    @foreach ($product->categories as $category)
                                    {{ $category->description }}
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('productos.show', $product->id) }}" class="btn btn-info btn-circle">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <a href="{{ route('productos.edit', $product->id) }}" class="btn btn-warning btn-circle">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-circle">
                                        <i class="fas fa-trash"></i>
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