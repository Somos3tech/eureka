@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/datatables.min.css') }}">
    @toastr_css
    <style>
        th,
        td {
            font-size: 13px;
        }

        .btn {
            border: none;
        }
    </style>
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
                    @can('terminalvalues.create')
                        <p>
                            <center><a class="btn btn-sm btn-info" href="#" data-toggle="modal"
                                    data-target="#terminalvaluesCreate" title="Registrar"><i class="ion-compose"></i>
                                    Registrar</a></center>
                        </p>
                    @endcan
                    <div id="terminalvalues" style="display:block;" class="box-body table-responsive">
                        <table id="terminalvalues-table" class="table table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>ID</center>
                                    </th>
                                    <th>
                                        <center>Fecha</center>
                                    </th>
                                    <th>
                                        <center>Modelo Terminal</center>
                                    </th>
                                    <th>
                                        <center>Divisa</center>
                                    </th>
                                    <th>
                                        <center>Valor Divisa</center>
                                    </th>
                                    <th>
                                        <center>Valor Bs.</center>
                                    </th>
                                    <th>
                                        <center>Observación</center>
                                    </th>
                                    <th>
                                        <center>Acción</center>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content-->
@endsection

@include('parameters::terminalvalues.create')
@include('parameters::terminalvalues.edit')
@include('parameters::terminalvalues.delete')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            flatpickr("#date_value", {
                minDate: '2001-01-01',
                locale: {
                    firstDayOfWeek: 1,
                    weekdays: {
                        shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                        longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes',
                            'Sábado'
                        ],
                    },
                    months: {
                        shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct',
                            'Nov', 'Dic'
                        ],
                        longhand: ['Enero', 'Febrero', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                            'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                        ],
                    },
                },
            });
            flatpickr("#date_value_up", {
                minDate: '2001-01-01',
                locale: {
                    firstDayOfWeek: 1,
                    weekdays: {
                        shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                        longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes',
                            'Sábado'
                        ],
                    },
                    months: {
                        shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct',
                            'Nov', 'Dic'
                        ],
                        longhand: ['Enero', 'Febrero', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                            'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                        ],
                    },
                },
            });
            $('#terminalvalues').show();
            listterminalvalues();
        });
        var listterminalvalues = function() {
            table = $('#terminalvalues-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/terminalvalues/datatable",
                columns: [{
                        data: "id",
                        "className": "text-center"
                    },
                    {
                        data: "date_value",
                        "className": "text-center"
                    },
                    {
                        data: "modelterminal",
                        "className": "text-center"
                    },
                    {
                        data: "currency",
                        "className": "text-center"
                    },
                    {
                        data: "amount_currency",
                        "className": "text-center"
                    },
                    {
                        data: "amount_local",
                        "className": "text-center"
                    },
                    {
                        data: "description",
                        "className": "text-center"
                    },
                    {
                        data: "actions",
                        "className": "text-center"
                    },
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [],
                order: [
                    [0, 'desc']
                ]
            });
        }

        /**************************************************************************/
        $.get('/mterminals/select', function(data) {
            $('#modelterminal_id').empty();
            $('#modelterminal_id').append("<option value=''>Seleccione Modelo Terminal...</option>");
            $.each(data, function(index, subMterminalObj) {
                $('#modelterminal_id').append("<option value='" + subMterminalObj.id + "'>" +
                    subMterminalObj.description + "</option>");
            });
        });
        /**************************************************************************/
        $.get('/currencies/select?local=N', function(data) {
            $('#currency_id').empty();
            $('#currency_id').append("<option value=''>Seleccione Divisa...</option>");
            $.each(data, function(index, subCurrencyObj) {
                $('#currency_id').append("<option value='" + subCurrencyObj.id + "'>" + subCurrencyObj
                    .abrev + "</option>");
            });
        });

        $("#create").click(function() {
            var date_value = $("#date_value").val();
            var currency_id = $("#currency_id").val();
            var modelterminal_id = $("#modelterminal_id").val();
            var amount_currency = $("#amount_currency").val();
            var amount_local = $("#amount_local").val();
            var description = $("#description").val();
            var route = "{{ route('terminalvalues.store') }}";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'post',
                dataType: 'json',
                data: {
                    date_value: date_value,
                    currency_id: currency_id,
                    modelterminal_id: modelterminal_id,
                    amount_currency: amount_currency,
                    amount_local: amount_local,
                    description: description
                },
                success: function(data) {
                    $("#terminalvaluesCreate").modal("hide");
                    $("#form-create")[0].reset();
                    $('#terminalvalues-table').DataTable().ajax.reload();
                    toastr.info("Se ha Registrado Correctamente")
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subTerminalvalueObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subTerminalvalueObj[0] +
                                '</li>';
                        } else {
                            notification = '<li>' + subTerminalvalueObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var terminalvalues = function(btn) {
            val = btn.value;
            var route = "{{ url('terminalvalues') }}/" + val + "/edit";
            $.get(route, function(res) {
                $("#id").val(res.id);
                $("#date_value_up").val(res.date_value);
                $("#currency_id_up").val(res.currency);
                $("#modelterminal").val(res.modelterminal);
                $("#amount_local_up").val(res.amount_local_up);
                $("#amount_currency_up").val(res.amount_currency_up);
                $("#description_up").val(res.description);
            })
        }
        $("#update").click(function() {
            var id = $("#id").val();
            var amount_local = $("#amount_local_up").val();
            var amount_currency = $("#amount_currency_up").val();
            var description = $("#description_up").val();

            var route = "{{ url('terminalvalues') }}/" + id;
            var token = $("#token").val();
            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'PUT',
                dataType: 'json',
                data: {
                    amount_currency: amount_currency,
                    amount_local: amount_local,
                    description: description
                },

                success: function(data) {
                    $("#terminalvaluesUpdate").modal("hide");
                    $("#form-edit")[0].reset();
                    $('#terminalvalues-table').DataTable().ajax.reload();
                    toastr.info("Registro se ha Actualizado Correctamente")

                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subTerminalvalueObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subTerminalvalueObj[0] +
                                '</li>';
                        } else {
                            notification = '<li>' + subTerminalvalueObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var terminalvaluesDelete = function(btn) {
            $("#id").val(btn.value);
        }

        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('terminalvalues') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#terminalvaluesDelete").modal("hide");
                    $('#terminalvalues-table').DataTable().ajax.reload();
                    toastr.info("Registro Eliminado Correctamente")
                },
                error: function(data) {
                    toastr.warning("Error al Eliminar Registro")
                }
            });
        });
        /**************************************************************************/
        $('.money').mask('000,000,000,000.00', {
            reverse: true
        });
        /**************************************************************************/
    </script>
@endsection
