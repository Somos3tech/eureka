@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/datatables.min.css') }}">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

    <!-- Plugins css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/style.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/index.js"></script>

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
        <h4>{{ $identity ?? 'Dashboard' }}</h4>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <!-- Content-->
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <center>
                        <div class="btn-group btn-sm">
                            <button type="button" class="btn btn-sm btn-dark">Gestión</button>
                            <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-toggle="dropdown">
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a class="btn btn-sm btn-default filter" class="btn btn-sm btn-default filter"
                                        data-toggle="modal" data-target="#createDomiciliation"
                                        title="Generar Gestión Cobranza Servicio"><i class="dripicons-info"></i>Generar
                                        Cobranza</a></li>
                                <li><a class="btn btn-sm btn-default filter" data-toggle="modal"
                                        data-target="#generateFileDomiciliation"
                                        title="Generar Archivo Cobranza Servicio"><i class="dripicons-info"></i>Generar
                                        Archivo</a></li>
                                <li><a class="btn btn-sm btn-default filter" data-toggle="modal"
                                        data-target="#reportDomiciliation" title="Generar Reporte Cobranza Servicio"><i
                                            class="dripicons-info"></i>Reporte</a></li>
                            </ul>
                        </div>
                        <div class="btn-group btn-sm">
                            <button type="button" class="btn btn-sm btn-warning" style="color: white;">Filtro(s)</button>
                            <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown"
                                style="color: white;">
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a id="management" class="btn btn-sm  btn-default filter">En Gestión</a></li>
                                <li><a id="create-filter" class="btn btn-sm btn-default filter">Generados</a></li>
                                <li><a id="process-filter" class="btn btn-sm btn-default filter">Procesados</a></li>
                                <li><a id="destroy" class="btn btn-sm btn-default filter">Anulados</a></li>
                            </ul>
                        </div>
                    </center>


                    <div id="domiciliations" style="display:block;" class="box-body table-responsive">
                        <br>
                        <table id="domiciliations-table" name="domiciliations-table"
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
                                        <center>Tipo Gestión</center>
                                    </th>
                                    <th>
                                        <center>Fecha Inicial</center>
                                    </th>
                                    <th>
                                        <center>Fecha Final</center>
                                    </th>
                                    <th>
                                        <center>Tarifa Bs. Digital</center>
                                    </th>
                                    <th>
                                        <center>Fecha Operación</center>
                                    </th>
                                    <th>
                                        <center>Archivo Enviado</center>
                                    </th>
                                    <th>
                                        <center>Domiciliación</center>
                                    </th>

                                    <th>
                                        <center>Resultado Domic.</center>
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
    <!-- Content-->
@endsection

@section('page-js')
    @include('sales::domiciliations.modals.show')
    @include('sales::domiciliations.modals.create')
    @include('sales::domiciliations.modals.generate')
    @include('sales::domiciliations.modals.delete')
    @include('sales::domiciliations.modals.upload')
    @include('sales::domiciliations.modals.send')
    @include('sales::domiciliations.modals.report')

    @include('sales::domiciliations.modals.process')

    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="assets/plugins/dropzone/dist/dropzone.js"></script>
    <script src="{{ asset('/assets/js/vendor/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>
    <script src="/assets/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#domiciliations').show();
            var status = 'Generado';
            listdomiciliation(status);
        });
        /****************************************************************************/
        flatpickr(".date_range", {
            mode: "range",
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr, instance) {
                instance.element.value = dateStr.replace('to', '|');
            },
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
        /****************************************************************************/
        flatpickr(".datepicker", {
            dateFormat: "Y-m-d",
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
        /****************************************************************************/
        flatpickr(".date_invoice", {
            dateFormat: "Y-m",
            plugins: [
                new monthSelectPlugin({
                    shorthand: true, //defaults to false
                    dateFormat: "Y-m", //defaults to "F Y"
                    altFormat: "F Y", //defaults to "F Y"
                    theme: "light" // defaults to "light"
                }),
            ],
        });
        /****************************************************************************/
        $.get('/banks/select', function(data) {
            $('.bank_id').empty();
            $('.bank_id').append("<option value=''>Seleccione Banco...</option>");
            $.each(data, function(index, subBankObj) {
                $('.bank_id').append("<option value='" + subBankObj.id + "'>" + subBankObj.description +
                    "</option>");
            });
        });
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
            maxFilesize: 600,
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
                    $("#uploadResponseDomiciliation").modal("hide");
                    $("#response-dropzone")[0].reset();
                    $('#domiciliations-table').DataTable().ajax.reload();
                    toastr.info(
                        "Cargado Resultado Bancario de Gestión Servicio Cobranza Correctamente al Sistema"
                    );
                });
            }
        };
        /****************************************************************************/
        var listdomiciliation = function(status) {
            var route = "/domiciliations/datatable?status=" + status;
            table = $('#domiciliations-table').DataTable({
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
                        data: "type_management",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "date_ini",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "date_end",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "amount_currency_old",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "date_operation",
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
        $('#management').on('click', function() {
            table.destroy();
            listdomiciliation('Enviado');
        });
        /****************************************************************************/
        $('#create-filter').on('click', function() {
            table.destroy();
            listdomiciliation('Generado');
        });
        /****************************************************************************/
        $('#process-filter').on('click', function() {
            table.destroy();
            listdomiciliation('Procesado');
        });
        /****************************************************************************/
        $('#destroy').on('click', function() {
            table.destroy();
            listdomiciliation('Anulado');
        });
        /****************************************************************************/
        $('#reset').on('click', function() {
            $('#domiciliations-table').DataTable().ajax.reload();
        });
        /****************************************************************************/

        /**********************Generar Cobranza Servicios****************************/
        $("#create").click(function() {
            type_service = document.getElementById("type_service").value;
            type_invoice = 'I';
            var date_invoice = document.getElementById("date_invoice").value;
            var fechpro = document.getElementById("fechpro").value;
            var date_range = document.getElementById("date_range").value;
            var type_date = document.getElementById("type_date").value;
            var type_weekly = document.getElementById("type_weekly").value;
            var bank_id = document.getElementById("bank_id").value;
            var route = "{{ route('services.store') }}";
            var token = "{{ csrf_token() }}";
            let data = {
                "type_service": type_service,
                "type_invoice": type_invoice,
                "type_date": type_date,
                "type_weekly": type_weekly,
                "bank_id": bank_id,
                "date_invoice": date_invoice,
                "fechpro": fechpro,
                "date_range": date_range
            };

            const showLoading = function() {
                swal({
                    icon: "info",
                    title: 'Generando Cobranza x Servicios, espere por favor',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })
            };

            showLoading();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                url: route,
                contentType: 'application/json',
                data: JSON.stringify(data), // access in body
                success: function(data) {
                    swal.close();
                    $("#createDomiciliation").modal("hide");
                    toastr.info(data.message)
                    $('#domiciliations-table').DataTable().ajax.reload();
                },
                error: function(data) {
                    swal.close();
                    //swal('','Error al Generar Cobranza','error');
                    data = Object.values(Object.values(data.responseJSON));
                    var alert = document.getElementById('danger');
                    document.getElementById("danger").innerHTML = "";
                    data = Object.values(data[1]);
                    for (i = 0; i < data.length; i++) {
                        $('<li>' + data[i] + '</li></ul>').prependTo('#danger');
                    }
                    $('<strong>Errores: </strong><ul>').prependTo('#danger');
                    alert.style.display = 'block';
                    $("#danger").fadeIn(1500);
                    $("#danger").fadeOut(5000);
                }
            });
        });
        /****************************************************************************/
        $('#type_service').on('change', function(e) {
            var type_service = e.target.value;
            $(".field").attr("style", "display:none");

            $('.input').removeAttr('required');
            $('.input').attr('disabled', 'disabled');

            document.getElementById("date_invoice").value = '';
            document.getElementById("fechpro").value = '';
            document.getElementById("date_range").value = '';
            switch (type_service) {
                case 'D':
                    $(".typeday").attr("style", "display:block");

                    $('#type_date').removeAttr('disabled');
                    $('#type_date').attr('required', true)
                    break;

                case 'S':
                    $(".months").attr("style", "display:block");
                    $(".type_weekly").attr("style", "display:block");

                    $('#type_weekly').removeAttr('disabled');
                    $('#type_weekly').attr('required', true);

                    $('.date_invoice').removeAttr('disabled');
                    $('.date_invoice').attr('required', true);
                    break;

                case 'M':
                    $(".months").attr("style", "display:block");

                    $('.date_invoice').removeAttr('disabled');
                    $('.date_invoice').attr('required', true);
                    break;
            }
        });
        /****************************************************************************/
        $('#type_date').on('change', function(e) {
            document.getElementById("date_invoice").value = '';
            document.getElementById("fechpro").value = '';
            document.getElementById("date_range").value = '';
            if (e.target.value == 'range') {
                $(".range").attr("style", "display:block");
                $(".day").attr("style", "display:none");

                $('#date_range').removeAttr('disabled');
                $('#date_range').attr('required', true);

                $('#fechpro').removeAttr('required');
                $('#fechpro').attr('disabled', 'disabled');
            } else {
                $(".day").attr("style", "display:block");
                $(".range").attr("style", "display:none");

                $('#fechpro').removeAttr('disabled');
                $('#fechpro').attr('required', true);

                $('#date_range').removeAttr('required');
                $('#date_range').attr('disabled', 'disabled');
            }
        });
        /****************************************************************************/

        /********************Generador Archivos Bancarios****************************/
        $("#generate").click(function() {
            showLoading();

            var bank_id = $("#bank_id2").val();
            var type_invoice = 'I';
            var type_manager = $("#type_manager").val();
            var type_date = $("#type_date2").val();
            var fechpro = $("#fechpro2").val();
            var date_range = $("#date_range2").val();
            var date_operation = $("#date_operation").val();
            var type_format = $("#type_format").val();
            var amount_currency = $("#amount_currency2").val();
            var type_response = 'json';

            let data = {
                bank_id: bank_id,
                type_invoice: type_invoice,
                type_manager: type_manager,
                type_format: type_format,
                amount_currency: amount_currency,
                type_response: type_response,
                type_date: type_date,
                fechpro: fechpro,
                date_range: date_range,
                date_operation: date_operation
            }
            var route = "{{ route('services.report.bank') }}";
            var token = "{{ csrf_token() }}";
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'GET',
                url: route,
                contentType: 'application/json',
                data: data, // access in body
                success: function(data) {
                    if (data.success) {
                        swal.close();
                        $("#generateFileDomiciliation").modal("hide");
                        swal({
                            icon: "info",
                            title: '<h5><b>Se genero Archivo Cobranza Bancaria, <br><br><br>Total Monto Divisa: $</b> ' +
                                data.result.total_amount_currency +
                                ' <br><br><b>Tarifa Cambio: Bs. </b>' + data.result.currency +
                                ' <br><br><b>Total Monto Bs. </b> ' + data.result.total_amount +
                                ' <br><br><b>Total Registros:</b> ' + data.result
                                .total_register + '</h5>',
                            allowEscapeKey: true,
                            allowOutsideClick: true
                        })
                        $('#domiciliations-table').DataTable().ajax.reload();
                    } else {
                        swal.close();
                        $("#generateFileDomiciliation").modal("hide");
                        toastr.info(data.message)
                        $('#domiciliations-table').DataTable().ajax.reload();
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
                    //toastr.error("Error el los siguientes Campos: </br>"+notification)
                    swal.close();
                }
            });
        });
        /****************************************************************************/
        $('#type_manager').on('change', function(e) {
            var type_service = e.target.value;
            $(".field").attr("style", "display:none");
            $('.input').val('');
            $('.input').removeAttr('required');
            $('.input').attr('disabled', 'disabled');
            switch (type_service) {
                case 'G':
                    $(".typeday").attr("style", "display:block");
                    $('#type_date2').removeAttr('disabled');
                    $('#type_date2').attr('required', true)
                    break;
                case 'R':
                    $('#type_date2').removeAttr('disabled');
                    $('#type_date2').attr('required', true)
                    $(".range").attr("style", "display:block");
                    $(".day").attr("style", "display:none");

                    $('#date_range2').removeAttr('disabled');
                    $('#date_range2').attr('required', true);

                    $('#fechpro2').removeAttr('required');
                    $('#fechpro2').attr('disabled', 'disabled');
                    break;
            }
        });
        /****************************************************************************/
        $('#type_date2').on('change', function(e) {
            if (e.target.value == 'range') {
                $(".range").attr("style", "display:block");
                $(".day").attr("style", "display:none");

                $('#date_range2').removeAttr('disabled');
                $('#date_range2').attr('required', true);

                $('#fechpro2').removeAttr('required');
                $('#fechpro2').attr('disabled', 'disabled');
            } else {
                $(".day").attr("style", "display:block");
                $(".range").attr("style", "display:none");

                $('#fechpro2').removeAttr('disabled');
                $('#fechpro2').attr('required', true);

                $('#date_range2').removeAttr('required');
                $('#date_range2').attr('disabled', 'disabled');
            }
        });
        /****************************************************************************/

        /****************************************************************************/
        var DomiciliationUpload = function(btn) {
            $("#upload_id").val(btn.value);
        }
        /****************************************************************************/
        var DomiciliationView = function(btn) {
            val = btn.value;
            var route = "{{ url('domiciliations') }}/" + val + "/edit";
            $(".view_input").empty();
            $.get(route, function(data) {
                $("#total_amount_view").append(data.total_amount);
                $("#amount_currency_view").append(data.amount_currency);
                $("#total_amount_currency_view").append(data.total_amount_currency);
                $("#total_register_view").append(data.total_register);
            });
        }
        /****************************************************************************/
        var DomiciliationSend = function(btn) {
            $("#send_id").val(btn.value);
        }
        /****************************************************************************/
        $("#send").click(function() {
            var id = $("#send_id").val();
            var route = "{{ url('domiciliations') }}/send/" + id + "";
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
                    $("#sendDomiciliation").modal("hide");
                    toastr.info(data.message)
                    $('#domiciliations-table').DataTable().ajax.reload();
                },
                error: function(data) {
                    $("#sendDomiciliation").modal("hide");
                    var alert = document.getElementById('danger');
                    document.getElementById("danger").innerHTML = "";
                    $('<strong>' + data.message + '</strong>').prependTo('#danger');
                    alert.style.display = 'block';
                    $("#danger").fadeIn(1500);
                    $("#danger").fadeOut(5000);
                }
            });
        });
        /****************************************************************************/
        var DomiciliationProcess = function(btn) {
            $("#process_id").val(btn.value);
        }
        /****************************************************************************/
        $("#process").click(function() {
            $("#processDomiciliation").modal("hide");
            showLoadingC();

            var id = $("#process_id").val();
            var route = "{{ url('domiciliations') }}/process/" + id + "";
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
                    $('#domiciliations-table').DataTable().ajax.reload();
                },
                error: function(data) {
                    $("#processDomiciliation").modal("hide");
                    var alert = document.getElementById('danger');
                    document.getElementById("danger").innerHTML = "";
                    $('<strong>' + data.message + '</strong>').prependTo('#danger');
                    alert.style.display = 'block';
                    $("#danger").fadeIn(1500);
                    $("#danger").fadeOut(5000);
                }
            });
        });
        /****************************************************************************/
        var DomiciliationDestroy = function(btn) {
            $("#id").val(btn.value);
        }
        /****************************************************************************/
        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('domiciliations') }}/" + id + "";
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
                    $("#deleteDomiciliation").modal("hide");
                    toastr.info(data.message)
                },
                error: function(data) {
                    $("#deleteDomiciliation").modal("hide");
                    var alert = document.getElementById('danger');
                    document.getElementById("danger").innerHTML = "";
                    $('<strong>' + data.message + '</strong>').prependTo('#danger');
                    alert.style.display = 'block';
                    $("#danger").fadeIn(1500);
                    $("#danger").fadeOut(5000);
                }
            });
        });
        /****************************************************************************/
        $('.money').mask('000,000,000,000,000.00', {
            reverse: true
        });
        /****************************************************************************/
        const showLoading = function() {
            swal({
                icon: "info",
                title: 'Generando Archivos de Cobro Bancario, Por favor espere mientras se procesa la Solicitud',
                allowEscapeKey: true,
                allowOutsideClick: true,
                onOpen: () => {
                    swal.showLoading();
                }
            })
        };
        /****************************************************************************/
        const showLoadingC = function() {
            swal({
                icon: "info",
                title: 'Procesando Conciliación x Cobro Bancario, Por favor espere mientras se procesa la Solicitud',
                allowEscapeKey: true,
                allowOutsideClick: true,
                onOpen: () => {
                    swal.showLoading();
                }
            })
        };
    </script>
@endsection
