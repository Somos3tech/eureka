@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/datatables.min.css') }}">
    <style>
        th,
        td {
            font-size: 13px;
        }

        input {
            outline: none;
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
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body row">
                    <div class="col-sm-10"></div>
                    <div class="col-sm-2">
                        <div class="btn-group">
                            <a id="reset" class="btn btn-sm btn-warning" style="color: white;" title="Actualizar"><i
                                    class="i i-Repeat"></i> Actualizar</a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div id="preafiliations" style="display:block;" class="box-body table-responsive">
                                    <table id="preafiliations-table" class="table table-striped table-bordered"
                                        cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <center>Acción</center>
                                                </th>
                                                <th>
                                                    <center>No. Registro</center>
                                                </th>
                                                <th>
                                                    <center>Creado</center>
                                                </th>

                                                <th>
                                                    <center>Status</center>
                                                </th>
                                                <th>
                                                    <center>RIF</center>
                                                </th>
                                                <th>
                                                    <center>Razón Social</center>
                                                </th>
                                                <th>
                                                    <center>Banco</center>
                                                </th>
                                                <th>
                                                    <center>Modelo Terminal</center>
                                                </th>
                                                <th>
                                                    <center>Divisas</center>
                                                </th>
                                                <th>
                                                    <center>Monto</center>
                                                </th>
                                                <th>
                                                    <center>Tarifa Cambio Bs.</center>
                                                </th>
                                                <th>
                                                    <center>Monto Bs.</center>
                                                </th>

                                                <th>
                                                    <center>Observación Asistente</center>
                                                </th>
                                                <th>
                                                    <center>Observación Vendedor</center>
                                                </th>
                                                <th>
                                                    Vendedor / Asistente
                                                </th>
                                                <th>
                                                    Aliado
                                                </th>
                                                <th>
                                                    Documentos
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
        </div>
    </div>
    <!-- Content-->
@endsection

@include('preafiliations::preafiliations.validmodal')
@include('preafiliations::preafiliations.show')
@include('preafiliations::preafiliations.delete')
@include('preafiliations::preafiliations.support')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    @toastr_js
    @toastr_render
    <script type="text/javascript">
        $(document).ready(function() {

            $('#preafiliations').show();
            var status = 'Cargado';
            listpreafiliations(status);
        });
        var listpreafiliations = function(status) {
            table = $('#preafiliations-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/preafiliations/validDatatable?status=" + status,
                columns: [{
                        data: "actions",
                        "className": "text-center",
                    },
                    {
                        data: "id",
                        "className": "text-center",
                    },
                    {
                        data: "created",
                        "className": "text-center",
                    },

                    {
                        data: "status_preafiliation",
                        "className": "text-center",
                    },
                    {
                        data: "rif",
                    },
                    {
                        data: "business_name",
                    },
                    {
                        data: "bank",
                    },
                    {
                        data: "modelterminal",
                    },
                    {
                        data: "currency",
                    },
                    {
                        data: "amount",
                    },
                    {
                        data: "dicom",
                    },
                    {
                        data: "amount_exchange",
                    },
                    {
                        data: "observations",
                    },
                    {
                        data: "observations_sale",
                    },
                    {
                        data: "user_created",
                    },
                    {
                        data: "consultant",
                    },
                    {
                        data: "documents",
                    },
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: []
            });
        }
        var preafiliations = function(btn) {
            var id = btn.value;
            $.get('/preafiliations/' + id, function(data) {
                $.each(data, function(index, subPreafiliationObj) {

                    $(".preafiliations").empty();
                    $(".preafiliations_views").empty();
                    document.getElementById("id").value = parseInt(subPreafiliationObj.id);
                    $("#document_views").append(subPreafiliationObj.rif);
                    $("#business_name_views").append(subPreafiliationObj.business_name);
                    $("#company_views").append(subPreafiliationObj.company);
                    $("#cactivity_views").append(subPreafiliationObj.cactivity);
                    $("#address_views").append(subPreafiliationObj.address);
                    $("#email_views").append(subPreafiliationObj.email);
                    $("#telephone_views").append(subPreafiliationObj.telephone);
                    $("#mobile_views").append(subPreafiliationObj.mobile);
                    $("#mobile2_views").append(subPreafiliationObj.mobile2);
                    $('#rm-detail-views > tbody').empty();
                    var tbl = document.getElementById("rm-detail-views");
                    var tblBody = document.createElement("tbody");
                    var rm = subPreafiliationObj.ident_number_r;
                    for (var i = 0; i < rm.length; i++) {
                        var fila = document.createElement("tr");

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subPreafiliationObj.ident_number_r[i]);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subPreafiliationObj.fullname_r[i]);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subPreafiliationObj.jobtitle_r[i]);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subPreafiliationObj.email_r[i]);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subPreafiliationObj.mobile_r[i]);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);


                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subPreafiliationObj.document_rm[i]);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        tblBody.appendChild(fila);
                    }
                    tbl.appendChild(tblBody);
                    tbl.setAttribute("border", "2");

                    $("#status").val(subPreafiliationObj.status);

                    if (subPreafiliationObj.is_rif != null && subPreafiliationObj.is_rif != 0) {
                        document.getElementById("is_rif").checked = true;
                        document.getElementById("is_rif").value = 1;
                    } else {
                        document.getElementById("is_rif").checked = false;
                        document.getElementById("is_rif").value = 0;
                    }

                    if (subPreafiliationObj.is_mercantil != null && subPreafiliationObj.is_mercantil !=
                        0) {
                        document.getElementById("is_mercantil").checked = true;
                        document.getElementById("is_mercantil").value = 1;
                    } else {
                        document.getElementById("is_mercantil").checked = false;
                        document.getElementById("is_mercantil").value = 0;
                    }

                    if (subPreafiliationObj.is_bank != null && subPreafiliationObj.is_bank != 0) {
                        document.getElementById("is_bank").checked = true;
                        document.getElementById("is_bank").value = 1;
                    } else {
                        document.getElementById("is_bank").checked = false;
                        document.getElementById("is_bank").value = 0;
                    }

                    if (subPreafiliationObj.is_auth_bank != null && subPreafiliationObj.is_auth_bank !=
                        0) {
                        document.getElementById("is_auth_bank").checked = true;
                        document.getElementById("is_auth_bank").value = 1;
                    } else {
                        document.getElementById("is_auth_bank").checked = false;
                        document.getElementById("is_auth_bank").value = 0;
                    }

                    if (subPreafiliationObj.is_payment != null && subPreafiliationObj.is_payment != 0) {
                        document.getElementById("is_payment").checked = true;
                        document.getElementById("is_payment").value = 1;
                    } else {
                        document.getElementById("is_payment").checked = false;
                        document.getElementById("is_payment").value = 0;
                    }

                    $("#status_preafiliation option[value=" + subPreafiliationObj.status + "]").attr(
                        "selected", true);
                });
            });
        }

        var preafiliationsView = function(btn) {
            var id = btn.value;
            $.get('/preafiliations/' + id, function(data) {

                $.each(data, function(index, subPreafiliationObj) {
                    $(".preafiliations_view").empty('');
                    $("#preafiliation_id").append(subPreafiliationObj.id);
                    $("#rif_view").append(subPreafiliationObj.rif);
                    $("#business_name_view").append(subPreafiliationObj.business_name);
                    $("#cactivity_view").append(subPreafiliationObj.cactivity);
                    $("#address_view").append(subPreafiliationObj.address);
                    $("#email_view").append(subPreafiliationObj.email);
                    $("#telephone_view").append(subPreafiliationObj.telephone);
                    $("#mobile_view").append(subPreafiliationObj.mobile);
                    $("#mobile2_view").append(subPreafiliationObj.mobile2);
                    $("#city_view").append(subPreafiliationObj.city);
                    $("#state_view").append(subPreafiliationObj.state);
                    $("#municipality_view").append(subPreafiliationObj.municipality);
                    $("#postal_code_view").append(subPreafiliationObj.postal_code);
                    $("#company_view").append(subPreafiliationObj.company);

                    $("#bank_view").append(subPreafiliationObj.bank);
                    $("#account_bank_view").append(subPreafiliationObj.account_bank);
                    $("#affiliate_number_view").append(subPreafiliationObj.affiliate_number);
                    $("#type_cont_view").append(subPreafiliationObj.type_cont_desc);
                    if (subPreafiliationObj.tax != null) {
                        $("#tax_view").append(subPreafiliationObj.tax + ' %');
                    } else {
                        $("#tax_view").append('0 %');
                    }

                    if (subPreafiliationObj.city_register != null && subPreafiliationObj
                        .city_register != '') {
                        $("#city_register_view").append(subPreafiliationObj.city_register);
                    } else {
                        $("#city_register_view").append('----');
                    }
                    if (subPreafiliationObj.comercial_register != null && subPreafiliationObj
                        .comercial_register != '') {
                        $("#comercial_register_view").append(subPreafiliationObj.comercial_register);
                    } else {
                        $("#comercial_register_view").append('----');
                    }
                    if (subPreafiliationObj.date_register != null && subPreafiliationObj
                        .date_register != '') {
                        $("#date_register_view").append(subPreafiliationObj.date_register);
                    } else {
                        $("#date_register_view").append('----');
                    }
                    if (subPreafiliationObj.number_register != null && subPreafiliationObj
                        .number_register != '') {
                        $("#number_register_view").append(subPreafiliationObj.number_register);
                    } else {
                        $("#number_register_view").append('----');
                    }
                    if (subPreafiliationObj.took_register != '' && subPreafiliationObj.took_register !=
                        '') {
                        $("#took_register_view").append(subPreafiliationObj.took_register);
                    } else {
                        $("#took_register_view").append('----');
                    }
                    if (subPreafiliationObj.clause_register != null && subPreafiliationObj
                        .clause_register != '') {
                        $("#clause_register_view").append(subPreafiliationObj.clause_register);
                    } else {
                        $("#clause_register_view").append('---');
                    }
                    if (subPreafiliationObj.observation_initial != null && subPreafiliationObj
                        .observation_initial != '') {
                        $("#observation_initial_view").append(subPreafiliationObj.observation_initial);
                    } else {
                        $("#observation_initial_view").append('Sin Observaciones');
                    }
                    $("#modelTerminal_view").append(subPreafiliationObj.modelterminal);
                    $("#operator_view").append(subPreafiliationObj.operator);
                    $("#term_view").append(subPreafiliationObj.term);
                    $("#pmethod_view").append(subPreafiliationObj.pmethod);
                    $("#currency_view").append(subPreafiliationObj.currency);

                    $("#amount_view").append(subPreafiliationObj.amount);
                    $("#amount_exchange_view").append(subPreafiliationObj.amount_exchange);
                    $("#currencyvalue_view").append(subPreafiliationObj.dicom);
                    $("#refere_view").append(subPreafiliationObj.refere);
                    $("#status_view").append(subPreafiliationObj.status_preafiliation);

                    $('#rm-detail > tbody').empty();
                    var tbl = document.getElementById("rm-detail");
                    var tblBody = document.createElement("tbody");
                    var rm = subPreafiliationObj.ident_number_r;
                    for (var i = 0; i < rm.length; i++) {
                        var fila = document.createElement("tr");

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subPreafiliationObj.ident_number_r[i]);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subPreafiliationObj.fullname_r[i]);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subPreafiliationObj.jobtitle_r[i]);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subPreafiliationObj.email_r[i]);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subPreafiliationObj.mobile_r[i]);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        tblBody.appendChild(fila);
                    }
                    tbl.appendChild(tblBody);
                    tbl.setAttribute("border", "2");
                });
            });
        }

        $('#is_rif').on('change', function() {
            if (document.getElementById("is_rif").checked == true) {
                document.getElementById("is_rif").value = 1;
            } else {
                document.getElementById("is_rif").checked = false;
                document.getElementById("is_rif").value = 0;
            }
        });

        $('#is_mercantil').on('change', function() {
            if (document.getElementById("is_mercantil").checked == true) {
                document.getElementById("is_mercantil").value = 1;
            } else {
                document.getElementById("is_mercantil").checked = false;
                document.getElementById("is_mercantil").value = 0;
            }
        });

        $('#is_bank').on('change', function() {
            if (document.getElementById("is_bank").checked == true) {
                document.getElementById("is_bank").value = 1;
            } else {
                document.getElementById("is_bank").checked = false;
                document.getElementById("is_bank").value = 0;
            }
        });
        $('#is_auth_bank').on('change', function() {
            if (document.getElementById("is_auth_bank").checked == true) {
                document.getElementById("is_auth_bank").value = 1;
            } else {
                document.getElementById("is_auth_bank").checked = false;
                document.getElementById("is_auth_bank").value = 0;
            }
        });

        $('#is_payment').on('change', function() {
            if (document.getElementById("is_payment").checked == true) {
                document.getElementById("is_payment").value = 1;
            } else {
                document.getElementById("is_payment").checked = false;
                document.getElementById("is_payment").value = 0;
            }
        });

        $('#status_preafiliation').empty();
        $('#status_preafiliation').append("<option value='Cargado'>Cargado</option>");
        $('#status_preafiliation').append("<option value='Procesado'>Procesado</option>");

        $('.valid').on('change', function() {
            var is_rif = document.getElementById("is_rif").value;
            var is_auth_bank = document.getElementById("is_auth_bank").value;
            var is_bank = document.getElementById("is_bank").value;
            var is_mercantil = document.getElementById("is_mercantil").value;
            var is_payment = document.getElementById("is_payment").value;
        });

        var preafiliationsSupport = function(btn) {
            $("#id").val(btn.value);
        }

        $("#valid-preafiliation").click(function() {
            var id = $("#id").val();
            var observations = $("#observations").val();
            var is_rif = $("#is_rif").val();
            var is_mercantil = $("#is_mercantil").val();
            var is_bank = $("#is_bank").val();
            var is_auth_bank = $("#is_auth_bank").val();
            var is_payment = $("#is_payment").val();
            var status = $("#status_preafiliation").val();
            let data = {
                "observations": observations,
                "is_rif": is_rif,
                "is_mercantil": is_mercantil,
                "is_bank": is_bank,
                "is_auth_bank": is_auth_bank,
                "is_payment": is_payment,
                "status": status,
                "valid": 1
            };
            var route = "/preafiliations/validation/" + id;
            var token = $("#token").val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'PUT',
                url: route,
                contentType: 'application/json',
                data: JSON.stringify(data), // access in body
                success: function(data) {
                    $('#preafiliationsUpdate').modal('toggle');
                    document.getElementById("form-valid").reset();
                    $('#preafiliations-table').DataTable().ajax.reload();
                    toastr.info("Preafiliación Procesada Correctamente")
                },
                error: function(data) {
                    toastr.info("Preafiliación No Procesada - Contacte a Soporte")
                }
            });
        });


        $("#support-preafiliation").click(function() {
            var id = $("#id").val();
            var observations = $("#observation_assistant").val();
            var user_observation = 'assistant';
            let data = {
                "observations": observations,
                "user_observation": user_observation
            };
            var route = "/preafiliations/support/" + id;
            var token = $("#token").val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'PUT',
                url: route,
                contentType: 'application/json',
                data: JSON.stringify(data), // access in body
                success: function(data) {
                    $('#preafiliationsSupport').modal('toggle');
                    document.getElementById("form-support").reset();
                    if (data) {
                        $('#preafiliations-table').DataTable().ajax.reload();
                        toastr.info("Solicitud Procesada Correctamente")
                    } else {
                        toastr.info("Solicitud No pudo ser Procesada")
                    }
                },
                error: function(data) {
                    toastr.error("Error al Procesar la Solicitud")
                }
            });
        });

        var CustomerDocument = function(btn) {
            var string = btn.value;
            var array = string.split("|");

            var uri = array[0];
            var path = array[1];
            var rif = array[2];
            window.open("/preafiliations/view-document?uri=" + uri + '&path=' + path + '&rif=' + rif,
                'Documento Información Cliente', 'width=800, height=400')
        }

        var preafiliationsDelete = function(btn) {
            $("#id").val(btn.value);
        }

        $("#delete-preafiliation").click(function() {
            var id = $("#id").val();
            var route = "{{ url('preafiliations') }}/" + id + "";

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#preafiliationsDelete").modal("hide");
                    $('#preafiliations-table').DataTable().ajax.reload();
                    toastr.info("Registro Eliminado Correctamente")
                },
                error: function(data) {
                    $("#preafiliationsDelete").modal("hide");
                    toastr.warning("Error al Eliminar Registro")
                }
            });
        });
        /************************************************************************/
        $('#reset').on('click', function() {
            $('#preafiliations-table').DataTable().ajax.reload();
        });
    </script>
@endsection
