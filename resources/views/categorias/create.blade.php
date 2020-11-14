@extends('layouts.app')

@section('title', ' - Crear categoría')

@section('content')
<link href="{{ asset('vendor/jquery-ui-1.12.1/jquery-ui.min.css') }}" rel="stylesheet" type="text/css">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Crear categoría</h1>
</div>

<!-- Content Row -->
<div class="row">

    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Complete el formulario para crear la categoría</h6>
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

                <form method="POST" action="{{ route('categorias.store') }}" autocomplete="off">
                    @csrf

                    <div class="form-row">
                        <div class="form-group col-md-6 {{ $errors->has('date') ? 'is-invalid' : '' }}">
                            <label for="description">Descripción</label>
                            <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}" require>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Crear categoría</button>
                </form>

            </div>
        </div>
    </div>

</div>
@endsection()