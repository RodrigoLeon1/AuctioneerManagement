@extends('layouts.app')

@section('title', ' - Listar categorías')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Listar categorías</h1>
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
            A continuación podrá observar el listado de las categorías creadas.
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="datatable-orders" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Fecha de creación</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Fecha de creación</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                    @forelse ($categories as $category)
                    <tr>
                        <td> {{ date('d/m/Y', strtotime($category->created_at)) }} </td>
                        <td> {{ $category->description }} </td>
                        <td>
                            <a href="{{ route('categorias.show', $category->id) }}" class="btn btn-info btn-circle">
                                <i class="fas fa-info-circle"></i>
                            </a>

                            <a href="{{ route('categorias.edit', $category->id) }}" class="btn btn-warning btn-circle">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('categorias.destroy', $category->id) }}" method="POST" style="display: inline-block;">
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
                        <td colspan="4">No se encontraron categorías registradas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection()