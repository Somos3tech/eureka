@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/datatables.min.css') }}">

    <link href="assets/plugins/dropzone/dist/basic.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <style>
        th,
        td {
            font-size: 11px;
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
                    <div class="row">
                        <div class="col-md-12 p-2">
                            <center>
                                <div class="btn-group btn-sm">
                                    <button type="button" class="btn btn-sm btn-dark">Gestión</button>
                                    <button type="button" class="btn btn-sm btn-dark dropdown-toggle"
                                        data-toggle="dropdown">
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a class="btn btn-sm btn-default filter" data-toggle="modal"
                                                data-target="#generateFileAdomiciliation"
                                                title="Generar Archivo Cobranza Servicio"><i
                                                    class="dripicons-info"></i>Generar Archivo</a></li>
                                        <li><a class="btn btn-sm btn-default filter" data-toggle="modal"
                                                data-target="#reportAdomiciliation"
                                                title="Generar Archivo Contratos Sin Afiliación Bancaría"><i
                                                    class="dripicons-info"></i>Reporte Pendientes</a></li>
                                    </ul>
                                </div>
                                <div class="btn-group btn-sm">
                                    <button type="button" class="btn btn-sm btn-warning"
                                        style="color:white;">Filtro(s)</button>
                                    <button type="button" class="btn btn-sm btn-warning dropdown-toggle"
                                        data-toggle="dropdown" style="color:white;">
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a id="management" class="btn btn-sm  btn-default filter">En Gestión</a></li>
                                        <li><a id="create-filter" class="btn btn-sm btn-default filter">Generados</a></li>
                                        <li><a id="process-filter" class="btn btn-sm btn-default filter">Procesados</a></li>
                                        <li><a id="destroy" class="btn btn-sm btn-default filter">Anulados</a></li>
                                    </ul>
                                </div>
                            </center>
                        </div>
                        <div class="col-sm-2 offset-md-10 p-2">
                            <a id="reset" class="btn btn-sm btn-warning" style="color: white;" title="Actualizar"><i
                                    class="fa fa-rotate-left"></i> Actualizar</a>
                        </div>
                        <div class="col-md-12 p-2">
                            <div id="adomiciliations" style="display:block;" class="box-body table-responsive">
                                <table id="adomiciliations-table" name="adomiciliations-table"
                                    class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                <center>Acción</center>
                                            </th>
                                            <th>
                                                <center>Fecha Generado</center>
                                            </th>
                                            <th>
                                                <center>Status</center>
                                            </th>
                                            <th>
                                                <center>Banco</center>
                                            </th>
                                            <th>
                                                <center>Archivo Enviado</center>
                                            </th>
                                            <th>
                                                <center>Afiliación</center>
                                            </th>

                                            <th>
                                                <center>Resultado Afiliación</center>
                                            </th>

                                            <th>
                                                <center>Generado Por</center>
                                            </th>
                                            <th>
                                                <center>Fecha Enviado</center>
                                            </th>
                                            <th>
                                                <center>Enviado Por</center>
                                            </th>
                                            <th>
                                                <center>Fecha Carga</center>
                                            </th>
                                            <th>
                                                <center>Cargado Por</center>
                                            </th>
                                            <th>
                                                <center>Fecha Proceso</center>
                                            </th>
                                            <th>
                                                <center>Procesado Por</center>
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
    <!-- Content-->
@endsection

@include('sales::adomiciliations.modals.show')
@include('sales::adomiciliations.modals.generate')
@include('sales::adomiciliations.modals.delete')
@include('sales::adomiciliations.modals.upload')
@include('sales::adomiciliations.modals.send')
@include('sales::adomiciliations.modals.report')

@include('sales::adomiciliations.modals.process')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="assets/plugins/dropzone/dist/dropzone.js"></script>
    <script src="{{ asset('/assets/js/vendor/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>
    <script src="/assets/js/select2.min.js"></script>

    <script type="text/javascript">
        /****************************************************************************/
        Dropzone.prototype.defaultOptions.dictDefaultMessage = "Arrastra los archivos aquí para subirlos";
        Dropzone.prototype.defaultOptions.dictFallbackMessage =
            "Su navegador no admite la carga de archivos mediante la función de arrastrar y soltar";
        Dropzone.prototype.defaultOptions.dictFallbackText =
            "Utilice el formulario de respaldo a continuación para cargar sus archivos como en los viejos tiempos";
        Dropzone.prototype.defaultOptions.dictFileTooBig = "El archivo es demasiado grande (MiB). Máx .: MiB.";
        Dropzone.prototype.defaultOptions.dictInvalidFileType = "No puede cargar archivos de este tipo.";
        Dropzone.prototype.defaultOptions.dictResponseError = "Server no responde Código:";
        Dropzone.prototype.defaultOptions.dictCancelUpload = "Cancelar Carga";
        Dropzone.prototype.defaultOptions.dictCancelUploadConfirmation = "Deseas cancelar esta carga?";
        Dropzone.prototype.defaultOptions.dictRemoveFile = "Remover Archivo";
        Dropzone.prototype.defaultOptions.dictMaxFilesExceeded = "No puede cargar más archivos.";

        Dropzone.options.responseDropzone = {
            autoProcessQueue: true,
            maxFilesize: 20,
            maxFiles: 1,
            init: function() {
                var submitBtn = document.querySelector("#response-dropzone");
                myDropzone = this;
                submitBtn.addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });
                this.on('sending', function(file, xhr, formData) {
                    formData.append('upload_id', document.getElementById("upload_id").value);
                });
                this.on("success", function(file, result) {
                    myDropzone.removeAllFiles(true);
                    $("#uploadResponseAdomiciliation").modal("hide");
                    $("#response-dropzone")[0].reset();
                    $('#adomiciliations-table').DataTable().ajax.reload();
                    toastr.info("Cargado Resultados Gestión Afiliación Bancaría Correctamente al Sistema")
                });
            }
        };
        $(document).ready(function() {
            $('#adomiciliations').show();
            var status = 'Generado';
            listadomiciliation(status);
        });

        /****************************************************************************/
        var listadomiciliation = function(status) {
            var route = "/adomiciliations/datatable?status=" + status;
            table = $('#adomiciliations-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 50,
                ajax: route,
                columns: [{
                        data: "actions",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "created",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "status_button",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "bank_name",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "send_email",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "file_bank",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "file_response",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "created_name",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "send_at",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "send_name",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "upload_at",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "upload_name",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "process_at",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "process_name",
                        "className": "text-center",
                        "width": "10%"
                    },
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [],
                "order": [
                    [2, "desc"]
                ]
            });
        }
        /****************************************************************************/
        $.get('/banks/select?is_register=1', function(data) {
            $('.bank_id').empty();
            $('.bank_id').append("<option value=''>Seleccione Banco...</option>");
            $.each(data, function(index, subBankObj) {
                $('.bank_id').append("<option value='" + subBankObj.id + "'>" + subBankObj.description +
                    "</option>");
            });
        });
        /****************************************************************************/
        $('#management').on('click', function() {
            table.destroy();
            listadomiciliation('Enviado');
        });
        /****************************************************************************/
        $('#create-filter').on('click', function() {
            table.destroy();
            listadomiciliation('Generado');
        });
        /****************************************************************************/
        $('#process-filter').on('click', function() {
            table.destroy();
            listadomiciliation('Procesado');
        });
        /****************************************************************************/
        $('#destroy').on('click', function() {
            table.destroy();
            listadomiciliation('Anulado');
        });
        /****************************************************************************/
        $('#reset').on('click', function() {
            $('#adomiciliations-table').DataTable().ajax.reload();
        });
        /****************************************************************************/
        /********************Generador Archivos Bancarios****************************/
        $("#generate").click(function() {
            showLoading();
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
                    if (data.success) {
                        swal.close();
                        $("#generateFileAdomiciliation").modal("hide");
                        swal({
                            icon: "info",
                            title: '<h5><b>Se genero Archivo Afiliación Bancaría, <br><br><br>Total Registros</b><br> ' +
                                data.result.total_register + '</h5>',
                            allowEscapeKey: true,
                            allowOutsideClick: true
                        })
                        $('#adomiciliations-table').DataTable().ajax.reload();
                    } else {
                        swal.close();
                        $("#generateFileAdomiciliation").modal("hide");
                        toastr.info(data.message)
                        $('#adomiciliations-table').DataTable().ajax.reload();
                    }
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subAfiliateObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subAfiliateObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subAfiliateObj[0] + '</li>';
                        }
                    });
                    //toastr.error("Error el los siguientes Campos: </br>"+notification)
                    swal.close();
                }
            });
        });
        /****************************************************************************/
        var AdomiciliationUpload = function(btn) {
            $("#upload_id").val(btn.value);
        }
        /****************************************************************************/
        var AdomiciliationView = function(btn) {
            val = btn.value;
            var route = "{{ url('adomiciliations') }}/" + val + "/edit";
            $(".view_input").empty();
            $.get(route, function(data) {
                $("#total_register_view").append(data.total_register);
                $("#bank_name_view").append(data.bank_name);
            });
        }
        /****************************************************************************/
        const showLoading = function() {
            swal({
                icon: "info",
                title: 'Generando Archivos de Afiliación Bancaría, Por favor espere mientras se procesa la Solicitud',
                allowEscapeKey: true,
                allowOutsideClick: true,
                onOpen: () => {
                    swal.showLoading();
                }
            })
        };

        /****************************************************************************/
        var AdomiciliationSend = function(btn) {
            $("#send_id").val(btn.value);
        }
        /****************************************************************************/
        $("#send").click(function() {
            var id = $("#send_id").val();
            var route = "{{ url('adomiciliations') }}/send/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'PUT',
                dataType: 'json',
                success: function(data) {
                    swal.close();
                    $("#sendAdomiciliation").modal("hide");
                    toastr.info(data.message)
                    $('#adomiciliations-table').DataTable().ajax.reload();
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subAfiliateObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subAfiliateObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subAfiliateObj[0] + '</li>';
                        }
                    });
                    //toastr.error("Error el los siguientes Campos: </br>"+notification)
                    swal.close();
                }
            });
        });
        /****************************************************************************/
        var AdomiciliationProcess = function(btn) {
            $("#process_id").val(btn.value);
        }
        /****************************************************************************/
        $("#process").click(function() {
            $("#processAdomiciliation").modal("hide");
            showLoadingC();

            var id = $("#process_id").val();
            var route = "{{ url('adomiciliations') }}/process/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    swal.close();
                    toastr.info(data.message)
                    $('#adomiciliations-table').DataTable().ajax.reload();
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subAfiliateObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subAfiliateObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subAfiliateObj[0] + '</li>';
                        }
                    });
                    swal.close();
                }
            });
        });
        /****************************************************************************/
        const showLoadingC = function() {
            swal({
                icon: "info",
                title: 'Procesando Afiliación Bancaría, Por favor espere mientras se procesa la Solicitud',
                allowEscapeKey: true,
                allowOutsideClick: true,
                onOpen: () => {
                    swal.showLoading();
                }
            })
        };
        /****************************************************************************/
        var AdomiciliationDestroy = function(btn) {
            $("#id").val(btn.value);
        }
        /****************************************************************************/
        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('adomiciliations') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    swal.close();
                    $("#deleteAdomiciliation").modal("hide");
                    $('#adomiciliations-table').DataTable().ajax.reload();
                    toastr.info(data.message)
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subAfiliateObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subAfiliateObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subAfiliateObj[0] + '</li>';
                        }
                    });
                    swal.close();
                }
            });
        });
        /****************************************************************************/
        $("#report").click(function() {
            var bank_id = $("#bankr_id").val();
            var uri = '/contracts/getAffiliatePending';
            location.href = uri + '?bank_id=' + bank_id;
        });
    </script>
@endsection
