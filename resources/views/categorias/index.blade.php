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

@if (session('success-restore'))
<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">
        {{ session('success-restore') }}
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
        <a href="{{ route('categorias.create') }}" class="btn btn-success btn-icon-split mb-4">
            <span class="text">Crear categoría</span>
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
        </a>

        <!-- Modal -->
        <button type="button" class="btn btn-warning btn-icon-split mb-4" data-toggle="modal" data-target="#exampleModal">
            <span class="text">Listar categorías eliminadas</span>
            <span class="icon text-white-50">
                <i class="fas fa-eye"></i>
            </span>
        </button>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Categorías eliminadas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatable-orders" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Fecha de creación</th>
                                        <th>Fecha de eliminación</th>
                                        <th>Descripción</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Fecha de creación</th>
                                        <th>Fecha de eliminación</th>
                                        <th>Descripción</th>
                                        <th>Acciones</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @forelse ($categoriesDeleted as $category)
                                    <tr>
                                        <td> {{ date('d/m/Y', strtotime($category->created_at)) }} </td>
                                        <td> {{ date('d/m/Y', strtotime($category->deleted_at)) }} </td>
                                        <td> {{ $category->description }} </td>
                                        <td>
                                            <a href="{{ route('categorias.restore', $category->id) }}" class="btn btn-warning btn-circle">
                                                <i class="fas fa-undo-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4">No se encontraron categorías eliminadas.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $categories->links() }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

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
                            <form action="{{ route('categorias.destroy', $category->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('¿Desea eliminar este registro?');">
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