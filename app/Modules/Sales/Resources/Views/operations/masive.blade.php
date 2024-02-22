@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @toastr_css
@endsection

@section('main-content')
    <div class="breadcrumb">
        <h1>{{ $identity ?? 'Dashboard' }}</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <!-- Content-->
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">

                    {!! Form::open(['id' => 'form', 'route' => 'operations.masive.store', 'method' => 'POST', 'files' => true]) !!}
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-2">
                            &nbsp;
                        </div>

                        <div class="col-sm-4">
                            <label class="col-sm-12"><b>Cargar Documento</b></label>
                            <input id="file" name="file" type="file" class="btn-dark" required>
                        </div>


                        <div class="col-sm-4">
                            <center>
                                <label class="col-sm-12">&nbsp;</label>
                                <button type="submit" class="btn btn-sm btn-dark"><i class="dripicons-upload"></i> Cargar
                                    Gestión Masiva</button>
                            </center>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="breadcrumb">
                <h2>Archivo de Referencia</h2>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <p>Puede descargar el archivo referencial Excel utlizado en el servicio de Cobranza Masiva. Favor tener
                        en cuenta lo siguiente:
                    </p>
                    <ul>
                        <li>La fecha debe encontrarse en formato "YYYY-MM-DD". Ejemplo: "2022-01-01"</li>
                        <li>Los numeros de cuenta contable se encuentran ubicados en el comentario de la columna "Cuenta
                            Contable"
                        </li>
                        <li>El separador decimal debe ser expresado con un punto (.) Ejemplo: "1000.00"
                        </li>
                    </ul>
                    <center>
                        <label class="col-sm-12">&nbsp;</label>
                        <a href="download/cargamasiva"><button type="submit" class="btn btn-sm btn-dark"><i
                                    class="dripicons-upload"></i>Descargar
                                Referencia</button></a>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <!-- Content-->
@endsection

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>


    @toastr_js
    @toastr_render
@endsection
