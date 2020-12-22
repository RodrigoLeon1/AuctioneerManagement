@extends('layouts.app')

@section('title', ' - Editar mercadería')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Editar mercadería</h1>
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
                <h6 class="m-0 font-weight-bold text-primary">Edité los campos que desee cambiar para la mercadería</h6>
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

                <form method="POST" action="{{ route('productos.update', $product->id) }}" autocomplete="off">
                    @csrf
                    @method('PUT')

                    @php
                    foreach ($product->categories as $category) {
                    $categoryId = $category->id;
                    }
                    @endphp

                    <div class="form-row form-dinamic">
                        <div class="form-group col-md-6">
                            <label>Descripción</label>
                            <input type="text" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description" value="{{ old('description', $product->description) }}" require>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Categoría</label>
                            <select class="form-control" name="category" id="category" require>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ ($category->id == $categoryId) ? 'selected' : '' }}>{{ $category->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Editar mercadería</button>
                </form>

            </div>
        </div>
    </div>

</div>
@endsection()