@extends('layouts.app')

@section('title', ' - 404 Archivo no encontrado')

@section('content')
<div class="text-center pt-5">
    <div class="error mx-auto" data-text="404">404</div>
    <p class="lead text-gray-800 mb-5">Archivo no encontrado</p>
    <p class="text-gray-500 mb-0">Compruebe la URL ingresada e intente nuevamente...</p>
    <a href="{{ route('dashboard') }}">← Volver al Dashboard</a>
</div>
@endsection()