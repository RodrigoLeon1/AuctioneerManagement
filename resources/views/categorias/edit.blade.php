@extends('layouts.app')

@section('title', ' - Editar categoría')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Editar categoría</h1>
</div>

@if (session('success-update'))
<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">
        {{ session('success-update') }}
    </h4>
</div>
@endif

<!-- Content Row -->
<div class="row">

    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Modifique los campos que desee cambiar para la categoría</h6>
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

                <form method="POST" action="{{ route('categorias.update', $category->id) }}" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="description">Descripción</label>
                            <input type="text" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" id="description" name="description" value="{{ $category->description }}" require>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Editar categoría</button>
                </form>

            </div>
        </div>
    </div>

</div>
@endsection()