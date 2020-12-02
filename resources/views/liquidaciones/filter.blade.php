@extends('layouts.app')

@section('title', ' - Filtrar liquidaciones')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Buscar {{ $user }}</h1>
</div>

<!-- Content Row -->
<div class="row">

    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Seleccione el tipo de filtro para encontrar al {{ $user }}</h6>
            </div>

            <div class="card-body">

                <form method="POST" action="{{ route('liquidaciones.create')}}" autocomplete="off">
                    @csrf

                    <div class="form-row justify-content-center">

                        <div class=" col-md-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input radio-dni" type="radio" name="type_search" id="type_search" value="dni" onclick="show_dni();">
                                <label class="form-check-label" for="type_search">
                                    DNI
                                </label>
                            </div>
                        </div>

                        <div class=" col-md-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input radio-cuit" type="radio" name="type_search" id="type_search" value="cuit" onclick="show_cuit();">
                                <label class="form-check-label" for="type_search">
                                    CUIT
                                </label>
                            </div>
                        </div>

                        <div class=" col-md-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input radio-cuit" type="radio" name="type_search" id="type_search" value="id" onclick="show_user_id();">
                                <label class="form-check-label" for="type_search">
                                    Identificador
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="form-row" id="dc-search" style="margin-top: 2rem;">
                        <div class="form-group offset-md-2 col-md-6">
                            <label id="search-name" for="search"></label>
                            <input type="text" class="form-control" id="search" name="search">
                        </div>
                        <div class="form-group col-md-2" style="display: flex; align-items: flex-end;">
                            <button class="btn btn-primary form-control" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>


                    <input type="hidden" name="user" value="{{$user}}" />
                </form>
            </div>
        </div>

    </div>

</div>




<style>
    [data-role="dynamic-fields"]>.form-dinamic+.form-dinamic {
        margin-top: 0.5em;
    }

    [data-role="dynamic-fields"]>.form-dinamic [data-role="add"] {
        display: none;
    }

    [data-role="dynamic-fields"]>.form-dinamic:last-child [data-role="add"] {
        display: inline-block;
    }

    [data-role="dynamic-fields"]>.form-dinamic:last-child [data-role="remove"] {
        display: none;
    }

    .user-search-container {
        margin-top: 3rem;
        width: 100%;
    }

    .user-search-input {
        width: 85%;
        height: 2.5rem;
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
        border: 2px solid #4e73df;
        border-right: none;
        padding-left: 1.5rem;
        padding-right: 1rem;
    }

    .user-search-btn {
        float: right;
        width: 15%;
        height: 2.5rem;
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
        border: 2px solid #4e73df;
        background: white;
        color: #4e73df;
    }

    .user-search-btn:hover {
        transition: all 0.5s ease;
        background: #4e73df;
        color: white;
    }

    .user-search-input:focus {
        outline: none;
    }

    .user-search-btn:focus {
        outline: none;
    }
</style>

<script>
    jQuery(document).ready(function($) {
        $(function() {
            // Remove button click
            $(document).on(
                'click',
                '[data-role="dynamic-fields"] > .form-dinamic [data-role="remove"]',
                function(e) {
                    e.preventDefault();
                    $(this).closest('.form-dinamic').remove();
                }
            );
            // Add button click
            $(document).on(
                'click',
                '[data-role="dynamic-fields"] > .form-dinamic [data-role="add"]',
                function(e) {
                    e.preventDefault();
                    var container = $(this).closest('[data-role="dynamic-fields"]');
                    new_field_group = container.children().filter('.form-dinamic:first-child').clone();
                    new_field_group.find('input').each(function() {
                        $(this).val('');
                    });
                    container.append(new_field_group);
                }
            );
        });
    });



    function toggle(elemento) {
        if (elemento.value == "a") {
            document.getElementById("uno").style.display = "none";
            document.getElementById("dos").style.display = "none";
        } else {
            if (elemento.value == "b") {
                document.getElementById("uno").style.display = "block";
                document.getElementById("dos").style.display = "none";
            } else {
                if (elemento.value == "c") {
                    document.getElementById("uno").style.display = "none";
                    document.getElementById("dos").style.display = "block";
                }
            }
        }
    }
</script>

@endsection()