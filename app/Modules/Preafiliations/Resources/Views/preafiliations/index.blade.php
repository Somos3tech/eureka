@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/dropzone.min.css') }}">
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
                <div class="card-body row">

                    <div class="col-sm-12">
                        <center>
                            <div class="btn-group btn-sm">
                                <button type="button" class="btn btn-sm btn-warning"
                                    style="color:white;">Filtro(s)</button>
                                <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown"
                                    style="color:white;"></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a id="generate" class="btn btn-sm  btn-default filter">Cargado</a></li>
                                    <li><a id="success" class="btn btn-sm btn-default filter">Procesado</a></li>
                                    <li><a id="destroy" class="btn btn-sm btn-default filter">Vencido</a></li>
                                </ul>
                            </div>
                        </center>
                    </div>

                    <div class="col-sm-10"></div>
                    <div class="col-sm-2">
                        <div class="btn-group">
                            <a id="reset" class="btn btn-sm btn-warning" style="color: white;" title="Actualizar"><i
                                    class="i i-Repeat"></i> Actualizar</a>
                        </div>
                    </div>
                    <div id="preafiliations" style="display:block;" class="box-body table-responsive">
                        <table id="preafiliations-table" class="table table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Ajustes</center>
                                    </th>
                                    <th>
                                        <center>No.</center>
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
                                        <center>Modelo Equipo</center>
                                    </th>
                                    <th>
                                        Divisas
                                    </th>
                                    <th>
                                        Monto
                                    </th>
                                    <th>
                                        Tarifa Cambio Bs.
                                    </th>
                                    <th>
                                        Monto Bs.
                                    </th>
                                    <th>
                                        Documentos
                                    </th>
                                    <th>
                                        <center>Observación Vendedor</center>
                                    </th>
                                    <th>
                                        <center>Observación Asistente</center>
                                    </th>

                                    <th>
                                        Vendedor
                                    </th>
                                    <th>
                                        Aliado
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

@include('preafiliations::preafiliations.show')
@include('preafiliations::preafiliations.uploadDashboard')
@include('preafiliations::preafiliations.support_sale')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/dropzone.min.js') }}"></script>
    @toastr_js
    @toastr_render
    <script type="text/javascript">
        Dropzone.options.rifDropzone = {
            autoProcessQueue: true,
            maxFilesize: 1,

            init: function() {
                var submitBtn = document.querySelector("#rif-dropzone");
                myDropzone = this;

                submitBtn.addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });
                this.on('sending', function(file, xhr, formData) {
                    formData.append('preafiliation_id', document.getElementById("preafiliation_id").value);
                    formData.append('type_document', 'rif');
                });
                this.on("success",
                    function(file, result) {
                        myDropzone.removeAllFiles(true);
                        $("#uploadRif").modal("hide");
                        $("#rif-dropzone")[0].reset();
                        $('#preafiliations-table').DataTable().ajax.reload();
                        toastr.info("Documento Rif Cargado Correctamente al Sistema")
                    });
            }
        };
        Dropzone.options.rmDropzone = {
            autoProcessQueue: true,
            maxFilesize: 1,

            init: function() {
                var submitBtn = document.querySelector("#rm-dropzone");
                myDropzone = this;

                submitBtn.addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });
                this.on('sending', function(file, xhr, formData) {
                    formData.append('preafiliation_id', document.getElementById("preafiliation_id").value);
                    formData.append('type_document', 'rm');
                });
                this.on("success",
                    function(file, result) {
                        myDropzone.removeAllFiles(true);
                        if (result) {
                            $("#uploadMercantil").modal("hide");
                            $("#rm-dropzone")[0].reset();
                            $('#preafiliations-table').DataTable().ajax.reload();
                            toastr.info("Registro Mercantíl Cargado Correctamente al Sistema")
                        } else {
                            toastr.error("Error al Cargar Documento al Sistema")
                        }
                    });
            }
        };
        Dropzone.options.bankDropzone = {
            autoProcessQueue: true,
            maxFilesize: 1,
            init: function() {
                var submitBtn = document.querySelector("#bank-dropzone");
                myDropzone = this;
                submitBtn.addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });
                this.on('sending', function(file, xhr, formData) {
                    formData.append('preafiliation_id', document.getElementById("preafiliation_id").value);
                    formData.append('type_document', 'bank');
                });
                this.on("success",
                    function(file, result) {
                        myDropzone.removeAllFiles(true);
                        if (result) {
                            $("#uploadBank").modal("hide");
                            $("#bank-dropzone")[0].reset();
                            $('#preafiliations-table').DataTable().ajax.reload();
                            toastr.info("Soporte Bancario Cargado Correctamente al Sistema")
                        } else {
                            toastr.error("Error al Cargar Documento al Sistema")
                        }
                    });
            }
        };
        Dropzone.options.authDropzone = {
            autoProcessQueue: true,
            maxFilesize: 1,

            init: function() {
                var submitBtn = document.querySelector("#auth-dropzone");
                myDropzone = this;

                submitBtn.addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });
                this.on('sending', function(file, xhr, formData) {
                    formData.append('preafiliation_id', document.getElementById("preafiliation_id").value);
                    formData.append('type_document', 'auth-bank');
                });
                this.on("success",
                    function(file, result) {
                        myDropzone.removeAllFiles(true);
                        $("#uploadAuthBank").modal("hide");
                        $("#auth-dropzone")[0].reset();
                        $('#preafiliations-table').DataTable().ajax.reload();
                        toastr.info("Autorización Débito Bancario Cargado Correctamente al Sistema")
                    });
            }
        };
        Dropzone.options.paymentDropzone = {
            autoProcessQueue: true,
            maxFilesize: 1,

            init: function() {
                var submitBtn = document.querySelector("#payment-dropzone");
                myDropzone = this;

                submitBtn.addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });
                this.on('sending', function(file, xhr, formData) {
                    formData.append('preafiliation_id', document.getElementById("preafiliation_id").value);
                    formData.append('type_document', 'payment');
                });
                this.on("success",
                    function(file, result) {
                        myDropzone.removeAllFiles(true);
                        $("#uploadPayment").modal("hide");
                        $("#payment-dropzone")[0].reset();
                        $('#preafiliations-table').DataTable().ajax.reload();
                        toastr.info("Soporte de Pago Cargado Correctamente al Sistema")
                    });
            }
        };
        Dropzone.options.rcustomerDropzone = {
            autoProcessQueue: true,
            maxFilesize: 1,

            init: function() {
                var submitBtn = document.querySelector("#rcustomer-dropzone");
                myDropzone = this;
                submitBtn.addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });
                this.on('sending', function(file, xhr, formData) {
                    formData.append('preafiliation_id', document.getElementById("preafiliation_id").value);
                    formData.append('type_document', 'rcustomer');
                    formData.append('consec', $("#consec").value);
                });
                this.on("success",
                    function(file, result) {
                        myDropzone.removeAllFiles(true);
                        $("#uploadRcustomer").modal("hide");
                        $("#detailsRcustomer").modal("hide");
                        $("#rcustomer-dropzone")[0].reset();
                        $('#preafiliations-table').DataTable().ajax.reload();
                        toastr.info("Documento Representante Cargado Correctamente al Sistema")
                    });
            }
        };
        /************************************************************************/
        $('#reset').on('click', function() {
            $('#preafiliations-table').DataTable().ajax.reload();
        });

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
                pageLength: 25,
                ajax: "/preafiliations/datatable?status=" + status,
                deferRender: true,
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
                        data: "documents",
                    },
                    {
                        data: "observations_sale",
                    },
                    {
                        data: "observations",
                    },
                    {
                        data: "user_created",
                    },
                    {
                        data: "consultant"
                    },
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                buttons: [{
                    extend: 'excel',
                    title: 'Reporte Preafiliaciones',
                    filename: 'Reporte_Preafiliaciones',
                    text: '<button class="btn btn-md btn-success"><i class="i i-File"></i> Descargar Excel</button>',
                    exportOptions: {
                        columns: [1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 13, 3, 14]
                    }
                }, ],
                dom: 'Bfrtip',
                "order": [
                    [1, "desc"]
                ]
            });
        }
        $('#generate').on('click', function() {
            table.destroy();
            var status = 'Cargado';
            listpreafiliations(status);
        });

        $('#success').on('click', function() {
            table.destroy();
            var status = 'Procesado';
            listpreafiliations(status);
        });

        $('#destroy').on('click', function() {
            table.destroy();
            var status = 'Vencido';
            listpreafiliations(status);
        });

        function uploadRcustomer(consec) {
            $("#consec").val(consec.value);
        }

        var preafiliations = function(btn) {
            document.getElementById("preafiliation_id").value = btn.value;
        }
        var Rcustomer = function(btn) {
            var preafiliation_id = btn.value;
            document.getElementById("preafiliation_id").value = preafiliation_id;
            $.get('/preafiliations/rcustomerDetail?preafiliation_id=' + preafiliation_id, function(data) {

                $('#rcustomer-detail > tbody').empty();
                var tbl = document.getElementById("rcustomer-detail");
                var tblBody = document.createElement("tbody");

                $.each(data, function(index, subRcustomerObj) {
                    if (typeof subRcustomerObj.path_document === 'undefined') {
                        var fila = document.createElement("tr");

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subRcustomerObj.ident_number);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subRcustomerObj.fullname);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subRcustomerObj.jobtitle);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subRcustomerObj.email);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subRcustomerObj.mobile);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var celda2 = document.createElement("div");
                        var center = document.createElement("center");
                        var button = document.createElement("button");
                        button.setAttribute("class", "btn btn-sm btn-info");
                        button.setAttribute("type", "button");
                        button.setAttribute("data-toggle", "modal");
                        button.setAttribute("data-target", "#uploadRcustomer");
                        button.setAttribute("onclick", "uploadRcustomer(this)");
                        button.setAttribute("value", subRcustomerObj.ident_number);
                        button.setAttribute("title", 'Cargar Documento Representante Legal');
                        var h = document.createElement("i");
                        h.setAttribute("class", "i-Cloud");
                        button.appendChild(h);
                        center.appendChild(button);
                        celda2.appendChild(center);
                        celda.appendChild(celda2);
                        fila.appendChild(celda);

                        tblBody.appendChild(fila);
                        tbl.appendChild(tblBody);
                        tbl.setAttribute("border", "2");
                    }
                });
            });
        }

        var preafiliationsView = function(btn) {
            var id = btn.value;
            $.get('/preafiliations/' + id, function(data) {
                $.each(data, function(index, subPreafiliationObj) {
                    $(".preafiliations_view").empty();
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
                    $("#account_bank_view").append(subPreafiliationObj.bank_code + subPreafiliationObj
                        .account_bank);
                    $("#affiliate_number_view").append(subPreafiliationObj.affiliate_number);
                    $("#type_cont_view").append(subPreafiliationObj.type_cont_desc);
                    if (subPreafiliationObj.tax != null) {
                        $("#tax_view").append(subPreafiliationObj.tax + ' %');
                    } else {
                        $("#tax_view").append('0 %');
                    }
                    $("#city_register_view").append(subPreafiliationObj.city_register);
                    $("#comercial_register_view").append(subPreafiliationObj.comercial_register);
                    $("#date_register_view").append(subPreafiliationObj.date_register);
                    $("#number_register_view").append(subPreafiliationObj.number_register);
                    $("#took_register_view").append(subPreafiliationObj.took_register);
                    $("#clause_register_view").append(subPreafiliationObj.clause_register);

                    $("#modelTerminal_view").append(subPreafiliationObj.modelterminal);
                    $("#operator_view").append(subPreafiliationObj.operator);
                    $("#term_view").append(subPreafiliationObj.term);
                    $("#pmethod_view").append(subPreafiliationObj.pmethod);
                    $("#currency_view").append(subPreafiliationObj.currency);
                    $("#observation_initial_view").append(subPreafiliationObj.observation_initial);

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
        var CustomerDocument = function(btn) {
            var string = btn.value;
            var array = string.split("|");

            var uri = array[0];
            var path = array[1];
            var rif = array[2];
            window.open("/preafiliations/view-document?uri=" + uri + '&path=' + path + '&rif=' + rif,
                'Documento Información Cliente', 'width=800, height=400')
        }

        var preafiliationsSupport = function(btn) {
            $("#id").val(btn.value);
        }

        $("#support-preafiliation").click(function() {
            var id = $("#id").val();
            var observations = $("#observation_sale").val();
            var user_observation = 'sales';
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
                    $('#preafiliationsSupportSale').modal('toggle');
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
    </script>
@endsection
