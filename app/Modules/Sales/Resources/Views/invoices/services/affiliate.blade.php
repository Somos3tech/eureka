@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        td {
            font-size: 11px;
        }

        th {
            font-size: 12px;
        }

        .btn {
            border: none;
        }

        .outlinenone {
            outline: none;
            background-color: #dfe;
            border: 0;
        }
    </style>
    @toastr_css
@endsection

@section('main-content')
    <div class="breadcrumb">
        <h1>{{ $identity ?? 'Dashboard' }}</h1>

    </div>
    <div class="separator-breadcrumb border-top"></div>
    <!-- Content-->
    <div class="row">
        <div class="col-sm-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h4><b>Generar Archivos Afiliación</b></h4>
                    {!! Form::open(['id' => 'form-generate', 'name' => 'form-generate']) !!}
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="col-sm-12 col-form-label"><b>Banco<small>*</small></b></label>
                            {!! Form::select('bank_id', ['' => 'Seleccione Banco...'], null, [
                                'id' => 'bank_id',
                                'class' => 'form-control bank_id',
                                'value' => old('bank_id'),
                            ]) !!}
                        </div>
                        <div class="col-sm-6">
                            <label>&nbsp;</label>
                            <center><a id="generate" name="generate" class="btn btn-info" data-toggle="tooltip"
                                    data-placement="top" title="Generar Archivo Bancario Afiliación"
                                    style="color: white;">Generar</a></center>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h4><b>Cargar Respuesta Afiliación</b></h4>
                    {!! Form::open([
                        'route' => 'services.affiliate.response',
                        'method' => 'POST',
                        'enctype' => 'multipart/form-data',
                    ]) !!}
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-5 p-1">
                            <label class="col-sm-12 col-form-label"><b>Banco<small>*</small></b></label>
                            {!! Form::select('bank_id2', ['' => 'Seleccione Banco...'], null, [
                                'id' => 'bank_id2',
                                'class' => 'form-control bank_id',
                            ]) !!}
                        </div>

                        <div class="col-sm-7 p-2">
                            <label class="col-sm-8"><b>Cargar Documento*</b></label>
                            <input id="file" name="file" type="file" class="btn btn-dark form-control">
                        </div>

                        <div class="col-sm-12">
                            <label>&nbsp;</label>
                            <center><button type="submit" id="response" name="response" class="btn btn-info"
                                    data-toggle="tooltip" data-placement="top" title="Cargar Resultados Bancarios"
                                    style="color: white;">Cargar</button></center>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <center>
                                <div class="btn-group btn-sm">
                                    <button type="button" class="btn btn-sm btn-dark" style="color:white;">Status
                                        Afiliación</button>
                                    <button type="button" class="btn btn-sm btn-dark dropdown-toggle"
                                        data-toggle="dropdown" style="color:white;"></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a id="confirmed" name="confirmes"
                                                class="btn btn-sm  btn-default filter">Afiliados</a></li>
                                        <li><a id="pending" name="pending"
                                                class="btn btn-sm btn-default filter">Generados</a></li>
                                    </ul>
                                </div>

                                <div class="btn-group btn-sm">
                                    <button type="button" class="btn btn-sm btn-dark" style="color:white;">Bancos</button>
                                    <button type="button" class="btn btn-sm btn-dark dropdown-toggle"
                                        data-toggle="dropdown" style="color:white;"></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <div id="banks-button"></div>
                                    </ul>
                                </div>
                            </center>
                        </div>

                        <div id="affiliates" style="display:block;" class="box-body table-responsive">
                            <table id="affiliate-table" class="table table-striped table-bordered" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>RIF</center>
                                        </th>
                                        <th>
                                            <center>Comercio</center>
                                        </th>
                                        <th>
                                            <center>No. Contrato</center>
                                        </th>
                                        <th>
                                            <center>Afiliado</center>
                                        </th>
                                        <th>
                                            <center>No. Cuenta Bancaría</center>
                                        </th>
                                        <th>
                                            <center>Banco</center>
                                        </th>
                                        <th>
                                            <center>Status Afiliación</center>
                                        </th>
                                        <th>
                                            <center>Fecha</center>
                                        </th>
                                        <th>
                                            <center>Status Contracto</center>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
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
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    <script type="text/javascript">
        flatpickr(".datepicker", {
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                    longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                },
                months: {
                    shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
                    longhand: ['Enero', 'Febrero', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                        'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                    ],
                },
            },
        });
        /************************************************************************/
        $.get('/banks/select?is_register=1', function(data) {
            $('.bank_id').empty();
            $('.bank_id').append("<option value=''>Seleccione Banco...</option>");

            $.each(data, function(index, subBankObj) {
                $('.bank_id').append("<option value='" + subBankObj.id + "'>" + subBankObj.description +
                    "</option>");
            });
        });
        /************************************************************************/
        $(document).ready(function() {
            $('#affiliates').show();
            listAffiliate('0');
        });
        /************************************************************************/
        var listAffiliate = function(is_register) {
            var route = "/raffiliates/datatable?is_register=" + is_register;
            table = $('#affiliate-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: route,
                columns: [{
                        data: "rif",
                        "className": "text-center"
                    },
                    {
                        data: "business_name",
                    },
                    {
                        data: "contract_id",
                        "className": "text-center"
                    },
                    {
                        data: "affiliate_number",
                        "className": "text-center"
                    },

                    {
                        data: "account_number",
                        "className": "text-center"
                    },
                    {
                        data: "bank_name",
                        "className": "text-center"
                    },
                    {
                        data: "validation",
                        "className": "text-center"
                    },
                    {
                        data: "affiliate_date",
                        "className": "text-center"
                    },
                    {
                        data: "status",
                        "className": "text-center"
                    },
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: []
            });
        }
        /************************************************************************/
        $('#pending').on('click', function() {
            table.clear().draw();
            table.destroy();
            listAffiliate('0');
        });
        /************************************************************************/
        $('#confirmed').on('click', function() {
            table.clear().draw();
            table.destroy();
            listAffiliate('1');
        });
        /**************************************************************************/
        $.get('/banks/select?is_register=1', function(data) {
            $('#banks-button').empty();
            Object.keys(data).forEach(function(key) {
                $('<li><a id="' + key + '" class="btn btn-sm btn-default filter">' + data[key].description +
                    '</a></li>').prependTo('#banks-button');
                $('#' + key).on('click', function() {
                    table.search('').columns().search('').draw();
                    table.columns(5).search(data[key].description).draw();
                });
            });
        });
        /**************************************************************************/
        $('#generate').on('click', function() {
            var bank_id = document.getElementById("bank_id").value;
            var route = "{{ route('services.affiliate.store') }}";
            var token = "{{ csrf_token() }}";

            let data = {
                "bank_id": bank_id
            };

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                url: route,
                contentType: 'application/json',
                data: JSON.stringify(data), // access in body
                success: function(data) {
                    if (data.message) {
                        toastr.info(data.message)
                    } else {
                        toastr.info("Se genero Archivo Afiliación Bancaría")
                    }
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subCompanyObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subCompanyObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subCompanyObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                    swal.close();
                }
            });
        });
        /**************************************************************************/
    </script>
@endsection
