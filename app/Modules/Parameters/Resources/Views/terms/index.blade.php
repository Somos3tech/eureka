@extends('layouts.compact-master')

@section('page-css')
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
                    @can('terms.create')
                        <p>
                            <center><a class="btn btn-sm btn-info" href="#" data-toggle="modal" data-target="#termsCreate"
                                    title="Registrar"><i class="ion-compose"></i> Registrar</a></center>
                        </p>
                    @endcan
                    <div id="terms" style="display:block;" class="box-body table-responsive">
                        <table id="terms-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Codigo</center>
                                    </th>
                                    <th>
                                        <center>Descripción</center>
                                    </th>
                                    <th>
                                        <center>Tipo Comisión</center>
                                    </th>
                                    <th>
                                        <center>Tipo Tarifa</center>
                                    </th>
                                    <th>
                                        <center>Divisa</center>
                                    </th>
                                    <th>
                                        <center>Tipo Cobranza</center>
                                    </th>
                                    <th>
                                        <center>Estado</center>
                                    </th>
                                    <th>
                                        <center>Acciones</center>
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

@include('parameters::terms.create')
@include('parameters::terms.edit')
@include('parameters::terms.delete')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            document.getElementById("check").style.display = 'none';
            document.getElementById("comission_id").disabled = true;
            document.getElementById("comission_flatrate").disabled = true;
            document.getElementById("comission_percentage").disabled = true;
            document.getElementById("amount_min").disabled = true;
            document.getElementById("amount_max").disabled = true;
            document.getElementById("comission_min").disabled = true;
            $('#terms').show();
            listterms();
        });

        var listterms = function() {
            table = $('#terms-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/terms/datatable",
                columns: [{
                        data: "abrev",
                        "className": "text-center"
                    },
                    {
                        data: "description",
                        "width": "35%"
                    },
                    {
                        data: "type_conditions",
                        "className": "text-center",
                        "width": "4%"
                    },
                    {
                        data: "type_conditions1",
                        "className": "text-center",
                        "width": "4%"
                    },
                    {
                        data: "currency",
                        "className": "text-center"
                    },
                    {
                        data: "type_invoice",
                        "className": "text-center"
                    },
                    {
                        data: "status",
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
                buttons: []
            });
        }

        $.get('/currencies/select', function(data) {
            $('.currency_id').empty();
            $('.currency_id').append("<option value=''>Seleccione Divisa...</option>");
            $.each(data, function(index, subCurrencyObj) {
                $('.currency_id').append("<option value='" + subCurrencyObj.id + "'>" + subCurrencyObj
                    .abrev + "</option>");
            });
        });

        $("#create").click(function() {
            var abrev = $("#abrev").val();
            var description = $("#description").val();
            var observations = $("#observations").val();
            var type_cond = $("#type_cond").val();
            var type_cond1 = $("#type_cond1").val();
            var currency_id = $("#currency_id").val();
            var type_invoice = $("#type_invoice").val();
            var comission_flatrate = $("#comission_flatrate").val();
            var comission_percentage = $("#comission_percentage").val();
            var comission_id = $("#comission_id").val();
            var amount_max = $("#amount_max").val();
            var amount_min = $("#amount_min").val();
            var prepaid = $("#prepaid").val();
            var check = $("#check").val();
            var comission_min = $("#comission_min").val();
            var route = "{{ route('terms.store') }}";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'post',
                dataType: 'json',
                data: {
                    abrev: abrev,
                    type_conditions: type_cond,
                    type_conditions1: type_cond1,
                    currency_id: currency_id,
                    description: description,
                    type_invoice: type_invoice,
                    prepaid: prepaid,
                    comission_id: comission_id,
                    comission_flatrate: comission_flatrate,
                    amount_min: amount_min,
                    check: check,
                    amount_max: amount_max,
                    comission_percentage: comission_percentage,
                    comission_min: comission_min,
                    observations: observations
                },
                success: function(data) {
                    $("#termsCreate").modal("hide");
                    $("#form-create")[0].reset();
                    $('#terms-table').DataTable().ajax.reload();
                    toastr.info("Se ha Registrado Correctamente")
                    document.getElementById("form-create").reset();
                    document.getElementById("check").style.display = 'none';
                    document.getElementById("comission_id").disabled = true;
                    document.getElementById("comission_flatrate").disabled = true;
                    document.getElementById("comission_percentage").disabled = true;
                    document.getElementById("amount_min").disabled = true;
                    document.getElementById("amount_max").disabled = true;
                    document.getElementById("comission_min").disabled = true;
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subTermObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subTermObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subTermObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var terms = function(btn) {
            val = btn.value;
            var route = "{{ url('terms') }}/" + val + "/edit";
            $.get(route, function(res) {
                $("#id").val(res.id);
                $("#abrev_up").val(res.abrev);
                $("#description_up").val(res.description);
                $("#observations_up").val(res.observations);
                $("#type_cond_up option[value=" + res.type_conditions + "]").attr("selected", true);
                $("#type_cond1_up option[value=" + res.type_conditions1 + "]").attr("selected", true);
                $("#type_invoice_up option[value=" + res.type_invoice + "]").attr("selected", true);
                $("#type_invoice_up").val(res.type_invoice);
                $("#currency_id_up option[value=" + res.currency + "]").attr("selected", true);

                if (res.prepaid != null) {
                    $("#prepaid_up option[value=" + res.prepaid + "]").attr("selected", true);
                } else {
                    document.getElementById("prepaid_up").value = 0;
                }

                if (res.comission_id != null) {
                    $.get('/comissions/select?condition=' + condition, function(data) {
                        $('#comission_id_up').empty();
                        $('#comission_id_up').append(
                            "<option value=''>Seleccione Comisión x Rango</option>");
                        $.each(data, function(index, subcomissionObj) {
                            $('#comission_id_up').append("<option value='" + subcomissionObj
                                .id + "'>" + subcomissionObj.description + "</option>");
                        });
                    });

                    $("#comission_id_up option[value=" + res.comission_id + "]").attr("selected", true);
                } else {
                    document.getElementById("comission_id_up").disabled = true;
                }


                if (res.comission_flatrate != null) {
                    $("#comission_flatrate_up").val(res.comission_flatrate);
                } else {
                    $("#comission_flatrate_up").val("----");
                    document.getElementById("comission_flatrate_up").disabled = true;
                }

                if (res.comission_percentage != null) {
                    $("#comission_percentage_up").val(res.comission_percentage + " %");
                } else {
                    $("#comission_percentage_up").val("----");
                    document.getElementById("comission_percentage_up").disabled = true;
                }

                if (res.amount_max != null) {
                    $("#amount_max_up").val(res.amount_max);
                } else {
                    $("#amount_max_up").val("----");
                    document.getElementById("amount_max_up").disabled = true;
                }

                if (res.amount_min != null) {
                    $("#amount_min_up").val(res.amount_min);
                } else {
                    $("#amount_min_up").val("----");
                    document.getElementById("amount_min_up").disabled = true;
                }

                if (res.comission_min != null) {
                    $("#comission_min_up").val(res.comission_min);
                } else {
                    $("#comission_min_up").val("----");
                    document.getElementById("comission_min_up").disabled = true;
                }
                $("#status_up").val(res.status);
            })
        }

        $("#update").click(function() {
            var id = $("#id").val();
            var abrev = $("#abrev_up").val();
            var description = $("#description_up").val();
            var observations = $("#observations_up").val();
            var type_cond = $("#type_cond_up").val();
            var type_cond1 = $("#type_cond1_up").val();
            var currency_id = $("#currency_id_up").val();
            var type_invoice = $("#type_invoice_up").val();
            var comission_flatrate = $("#comission_flatrate_up").val();
            var comission_percentage = $("#comission_percentage_up").val();
            var comission_id = $("#comission_id_up").val();
            var amount_max = $("#amount_max_up").val();
            var amount_min = $("#amount_min_up").val();
            var prepaid = $("#prepaid_up").val();
            var check = $("#check_up").val();
            var comission_min = $("#comission_min_up").val();
            var route = "{{ url('terms') }}/" + id;
            var token = $("#token").val();
            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'PUT',
                dataType: 'json',
                data: {
                    abrev: abrev,
                    type_conditions: type_cond,
                    type_conditions1: type_cond1,
                    currency_id: currency_id,
                    description: description,
                    type_invoice: type_invoice,
                    prepaid: prepaid,
                    comission_id: comission_id,
                    comission_flatrate: comission_flatrate,
                    amount_min: amount_min,
                    check: check,
                    amount_max: amount_max,
                    comission_percentage: comission_percentage,
                    comission_min: comission_min,
                    observations: observations
                },

                success: function(data) {
                    $("#termsUpdate").modal("hide");
                    $("#form-edit")[0].reset();
                    $('#terms-table').DataTable().ajax.reload();
                    toastr.info("Registro se ha Actualizado Correctamente")

                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subTermObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subTermObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subTermObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var termsDelete = function(btn) {
            $("#id").val(btn.value);
        }

        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('terms') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#termsDelete").modal("hide");
                    $('#terms-table').DataTable().ajax.reload();
                    toastr.info("Registro Eliminado Correctamente")
                },
                error: function(data) {
                    toastr.warning("Error al Eliminar Registro")
                }
            });
        });
    </script>

    <script type="text/javascript">
        function comprobar() {
            var type_cond = $("#type_cond option:selected").val();
            var type_cond1 = $("#type_cond1 option:selected").val();

            if (type_cond == 'Tarifa' && type_cond1 == 'Fijo') { //Tarifa Fija
                document.getElementById('check').style.display = 'none';
                document.getElementById("check").value = 'on';
                document.getElementById("amount_min").disabled = true;

                document.getElementById("comission_id").disabled = true;

                document.getElementById("comission_flatrate").disabled = false;
                document.getElementById("comission_percentage").disabled = true;

                document.getElementById("comission_min").disabled = true;
                document.getElementById("amount_max").disabled = true;
            }
            if (type_cond == 'Tarifa' && type_cond1 == 'Rango') { //este
                document.getElementById('check').style.display = 'none';
                document.getElementById("check").value = 'on';
                document.getElementById("amount_min").disabled = true;

                document.getElementById("comission_id").disabled = false;

                document.getElementById("comission_flatrate").disabled = true;
                document.getElementById("comission_percentage").disabled = true;

                document.getElementById("comission_min").disabled = true;
                document.getElementById("amount_max").disabled = true;

                var condition = 'Tarifa';
            }
            if (type_cond == 'Porcentaje' && type_cond1 == 'Fijo') {
                document.getElementById('check').style.display = 'none';
                document.getElementById("check").value = 'on';
                document.getElementById("amount_min").disabled = true;

                document.getElementById("comission_id").disabled = true;
                document.getElementById("comission_flatrate").disabled = true;
                document.getElementById("comission_percentage").disabled = false;

                document.getElementById("comission_min").disabled = true;
                document.getElementById("amount_max").disabled = true;
            }
            if (type_cond == 'Porcentaje' && type_cond1 == 'Rango') {
                document.getElementById('check').style.display = 'none';
                document.getElementById("check").value = 'on';
                document.getElementById("amount_min").disabled = true;

                document.getElementById("comission_id").disabled = false;
                document.getElementById("comission_flatrate").disabled = true;
                document.getElementById("comission_percentage").disabled = true;

                document.getElementById("comission_min").disabled = true;
                document.getElementById("amount_max").disabled = true;

                var condition = 'Porcentaje';
            }
            if (type_cond == 'Mixto' && type_cond1 == 'Fijo') {
                document.getElementById('check').style.display = 'block';

                document.getElementById("comission_id").disabled = true;
                document.getElementById("comission_flatrate").disabled = true;
                document.getElementById("comission_percentage").disabled = false;

                document.getElementById("comission_min").disabled = false;
                document.getElementById("amount_max").disabled = false;
            }
            if (type_cond == 'Mixto' && type_cond1 == 'Rango') {
                document.getElementById('check').style.display = 'block';

                document.getElementById("comission_id").disabled = false;
                document.getElementById("comission_flatrate").disabled = true
                document.getElementById("comission_percentage").disabled = true;

                document.getElementById("comission_min").disabled = false;
                document.getElementById("amount_max").disabled = false;

                var condition = 'Porcentaje';

            }
            $.get('/comissions/select?condition=' + condition, function(data) {
                $('#comission_id').empty();
                $('#comission_id').append("<option value=''>Seleccione Comisión x Rango</option>");
                $.each(data, function(index, subcomissionObj) {
                    $('#comission_id').append("<option value='" + subcomissionObj.id + "'>" +
                        subcomissionObj.description + "</option>");
                });
            });
        }

        function comprobar2() {
            var type_cond = $("#type_cond_up option:selected").val();
            var type_cond1 = $("#type_cond1_up option:selected").val();

            if (type_cond == 'Tarifa' && type_cond1 == 'Fijo') {
                document.getElementById('check_up').style.display = 'none';
                document.getElementById("check_up").value = 'on';
                document.getElementById("amount_min").disabled = true;

                document.getElementById("comission_id_up").disabled = true;

                document.getElementById("comission_flatrate_up").disabled = false;
                document.getElementById("comission_percentage_up").disabled = true;

                document.getElementById("comission_min_up").disabled = true;
                document.getElementById("amount_max_up").disabled = true;
            }
            if (type_cond == 'Tarifa' && type_cond1 == 'Rango') { //este
                document.getElementById('check_up').style.display = 'none';
                document.getElementById("check_up").value = 'on';
                document.getElementById("amount_min_up").disabled = true;

                document.getElementById("comission_id_up").disabled = false;

                document.getElementById("comission_flatrate_up").disabled = true;
                document.getElementById("comission_percentage_up").disabled = true;

                document.getElementById("comission_min_up").disabled = true;
                document.getElementById("amount_max_up").disabled = true;

                var condition = 'Tarifa';
            }
            if (type_cond == 'Porcentaje' && type_cond1 == 'Fijo') {
                document.getElementById('check_up').style.display = 'none';
                document.getElementById("check_up").value = 'on';
                document.getElementById("amount_min_up").disabled = true;

                document.getElementById("comission_id_up").disabled = true;
                document.getElementById("comission_flatrate_up").disabled = true;
                document.getElementById("comission_percentage_up").disabled = false;

                document.getElementById("comission_min_up").disabled = true;
                document.getElementById("amount_max_up").disabled = true;
            }
            if (type_cond == 'Porcentaje' && type_cond1 == 'Rango') {
                document.getElementById('check_up').style.display = 'none';
                document.getElementById("check_up").value = 'on';
                document.getElementById("amount_min_up").disabled = true;

                document.getElementById("comission_id_up").disabled = false;
                document.getElementById("comission_flatrate_up").disabled = true;
                document.getElementById("comission_percentage_up").disabled = true;

                document.getElementById("comission_min_up").disabled = true;
                document.getElementById("amount_max_up").disabled = true;

                var condition = 'Porcentaje';
            }
            if (type_cond == 'Mixto' && type_cond1 == 'Fijo') {
                document.getElementById('check_up').style.display = 'block';

                document.getElementById("comission_id_up").disabled = true;
                document.getElementById("comission_flatrate_up").disabled = true;
                document.getElementById("comission_percentage_up").disabled = false;

                document.getElementById("comission_min_up").disabled = false;
                document.getElementById("amount_max_up").disabled = false;
            }
            if (type_cond == 'Mixto' && type_cond1 == 'Rango') {
                document.getElementById('check_up').style.display = 'block';

                document.getElementById("comission_id_up").disabled = false;
                document.getElementById("comission_flatrate_up").disabled = true
                document.getElementById("comission_percentage_up").disabled = true;

                document.getElementById("comission_min_up").disabled = false;
                document.getElementById("amount_max_up").disabled = false;

                var condition = 'Porcentaje';

            }
            $.get('/comissions/select?condition=' + condition, function(data) {
                $('#comission_id_up').empty();
                $('#comission_id_up').append("<option value=''>Seleccione Comisión x Rango</option>");
                $.each(data, function(index, subcomissionObj) {
                    $('#comission_id_up').append("<option value='" + subcomissionObj.id + "'>" +
                        subcomissionObj.description + "</option>");
                });
            });
        }

        function checkAmount() {
            if ($('#check').prop('checked')) {
                document.getElementById("check").value = '1';
                document.getElementById("amount_min").disabled = false;
            } else {
                document.getElementById("check").value = 'on';
                document.getElementById("amount_min").disabled = true;
            }
        }

        function checkAmount2() {
            if ($('#check_up').prop('checked_up')) {
                document.getElementById("check_up").value = '1';
                document.getElementById("amount_min_up").disabled = false;
            } else {
                document.getElementById("check_up").value = 'on';
                document.getElementById("amount_min_up").disabled = true;
            }
        }
        $('.money').mask(' 000,000,000.00', {
            reverse: true
        });

        $('.porcentage').mask('AA', {
            'translation': {
                A: {
                    pattern: /[0-9]/
                }
            }
        });
    </script>
@endsection
