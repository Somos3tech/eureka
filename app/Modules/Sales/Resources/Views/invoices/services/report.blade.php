@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
                    <form id="form" name="form-control csupport">
                        <div class="row">
                            <div class="col-sm-1" style="display:none">
                                {!! Form::select('type_invoice', ['I' => 'Cobranza'], null, [
                                    'id' => 'type_invoice',
                                    'class' => 'form-control select2',
                                ]) !!}
                            </div>

                            <div class="col-sm-3">
                                <label for="bank_id" class="col-sm-12 col-form-label"><b>Banco*</b></label>
                                {!! Form::select('bank_id', ['' => 'Seleccione Banco...'], null, ['id' => 'bank_id', 'class' => 'form-control']) !!}
                            </div>


                            <div class="col-sm-3 type_invoice">
                                <label for="type_manager" class="col-sm-12 col-form-label"><b>Tipo Formato*</b></label>
                                <!--, -->
                                {!! Form::select('type_format', ['bank' => 'Formato Bancario', 'excel' => 'Formato Excel'], null, [
                                    'id' => 'type_format',
                                    'class' => 'form-control',
                                ]) !!}
                            </div>

                            <div class="col-sm-3">
                                <label for="dicom" class="col-sm-12 col-form-label"><b>Tárifa*</b></label>
                                {!! Form::text('amount_currency', null, [
                                    'id' => 'amount_currency',
                                    'class' => 'form-control money blank',
                                    'placeholder' => 'Ingrese Tarifa Cambio',
                                ]) !!}
                            </div>

                            <div class="col-sm-3 type_invoice">
                                <label for="type_manager" class="col-sm-12 col-form-label"><b>Tipo Gestión*</b></label>
                                {!! Form::select(
                                    'type_manager',
                                    ['' => 'Seleccionar Tipo Gestión...', 'G' => 'Diario', 'M' => 'Masivo', 'R' => 'Morosidad'],
                                    null,
                                    ['id' => 'type_manager', 'class' => 'form-control'],
                                ) !!}
                            </div>
                            <div class="col-sm-12">
                                <hr>
                            </div>
                            <div class="col-sm-3 field typeday" style="display:none;">
                                <label for="type_date" class="col-sm-12"><b>Tipo Fecha*</b></label>
                                {!! Form::select(
                                    'type_date',
                                    ['' => 'Seleccione Tipo Fecha...', 'date' => 'Fecha única', 'range' => 'Fecha Rango'],
                                    null,
                                    ['id' => 'type_date', 'class' => 'form-control input'],
                                ) !!}
                            </div>

                            <div class="col-sm-4 field range" style="display:none;">
                                <label><b>Cobranza - Rango</b></label>
                                <div>
                                    <div class="input-daterange input-group" id="date-range">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="i i-Calendar"></i></span>
                                        </div>
                                        <input type="text" class="form-control input date_range" id="date_range"
                                            name="date_range" placeholder="aaaa-mm-dd | aaaa-mm-dd" data-toggle="datepicker"
                                            readonly />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3 field day" style="display:none;">
                                <div class="col-sm-12">
                                    <label for="date_invoice" class="col-sm-12"><b>Cobranza<small>*</small></b></label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="i i-Calendar"></i></span>
                                        </div>
                                        <input id="fechpro" name="fechpro" type="text"
                                            class="form-control input datepicker fechpro" placeholder="aaaa-mm-dd"
                                            data-toggle="datepicker" readonly>
                                    </div><!-- input-group -->
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <br>
                                <center><a class='btn btn-sm btn-info' id="generate" name="generate"
                                        style="color:white;">Generar Archivo</a></center>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Content-->
@endsection

@section('page-js')
    <script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/sweetalert2.min.js') }}"></script>

    @toastr_js
    @toastr_render
    <script type="text/javascript">
        $(document).ready(function() {

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
                        longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes',
                            'Sábado'],
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

            flatpickr(".datepicker", {
                dateFormat: "Y-m-d",
                locale: {
                    firstDayOfWeek: 1,
                    weekdays: {
                        shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                        longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes',
                            'Sábado'],
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

            $.get('/banks/select', function(data) {
                $('#bank_id').empty();
                $('#bank_id').append("<option value=''>Seleccione Banco...</option>");
                $.each(data, function(index, subBankObj) {
                    $('#bank_id').append("<option value='" + subBankObj.id + "'>" + subBankObj
                        .description + "</option>");
                });
            });
        });
        /**************************************************************************/
        $("#generate").click(function() {
            showLoading();

            var bank_id = $("#bank_id").val();
            var type_invoice = $("#type_invoice").val();
            var type_manager = $("#type_manager").val();
            var type_date = $("#type_date").val();
            var fechpro = $("#fechpro").val();
            var date_range = $("#date_range").val();
            var type_format = $("#type_format").val();
            var amount_currency = $("#amount_currency").val();
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
                date_range: date_range
            }
            let data_document = {
                bank_id: bank_id,
                type_invoice: type_invoice,
                type_manager: type_manager,
                type_format: type_format,
                amount_currency: amount_currency,
                type_response: '',
                type_date: type_date,
                fechpro: fechpro,
                date_range: date_range
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
                    if (data.status == 1) {
                        swal.close()
                        swal({
                            title: "Reasignación No. Ordenante x Cobros de Servicios",
                            text: data.message,
                            type: "info",
                            showCancelButton: true,
                            confirmButtonText: "Reasignar",
                            cancelButtonText: "Cancelar"
                        }).then(function(isConfirm) {
                            /* Read more about isConfirmed, isDenied below */
                            if (isConfirm) {
                                showLoading();
                                var route2 = "{{ route('consecutives.destroy.bank') }}";
                                var token = "@csrf_token";
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': token
                                    },
                                    type: 'GET',
                                    url: route,
                                    contentType: 'application/json',
                                    success: function(data) {
                                        if (data) {
                                            var uri = route + '?bank_id=' +
                                                bank_id + '&type_invoice=' +
                                                type_invoice + '&type_manager=' +
                                                type_manager + '&type_format=' +
                                                type_format + '&amount_currency=' +
                                                amount_currency +
                                                '&type_response=&type_date=' +
                                                type_date + '&fechpro=' + fechpro +
                                                '&date_range=' + date_range;
                                            location.href = uri;
                                            swal({
                                                icon: "info",
                                                title: '<b><h4>Se esta generando Archivo Cobranza Bancaria, espere un momento mientras Descarga</h4><h5></b> <br><b>Total Monto Divisa: </b>$ ' +
                                                    data
                                                    .total_amount_currency +
                                                    ' <br><b>Tarifa Cambio: </b>Bs. ' +
                                                    data.currency +
                                                    ' <br><b>Total Monto </b> Bs. ' +
                                                    data.total_amount +
                                                    ' <br><b>Total Registros:</b> ' +
                                                    data.cont + '</h5>',
                                                allowEscapeKey: true,
                                                allowOutsideClick: true,
                                            })
                                        } else {
                                            swal.close();
                                            toastr.info(
                                                "No se ha pudo Generar el Archivo, Consulte con Soporte de Eureka"
                                                )
                                        }
                                    },
                                    error: function(data) {
                                        swal.close();
                                        toastr.info(
                                            "No se ha pudo Generar el Archivo, Consulte con Soporte de Eureka"
                                            )
                                    }
                                });
                            } else {
                                swal.close();
                                toastr.info("No se ha generado ningún Proceso de Cobranza")
                            }
                        });
                    } else {
                        var uri = route + '?bank_id=' + bank_id + '&type_invoice=' + type_invoice +
                            '&type_manager=' + type_manager + '&type_format=' + type_format +
                            '&amount_currency=' + amount_currency + '&type_response=&type_date=' +
                            type_date + '&fechpro=' + fechpro + '&date_range=' + date_range;
                        location.href = uri;

                        swal({
                            icon: "info",
                            title: '<b><h4>Se esta generando Archivo Cobranza Bancaria, espere un momento mientras Descarga</h4><h5></b> <br><b>Total Monto Divisa: </b>$ ' +
                                data.total_amount_currency + ' <br><b>Tarifa Cambio: </b>Bs. ' +
                                data.currency + ' <br><b>Total Monto </b> Bs. ' + data
                                .total_amount + ' <br><b>Total Registros:</b> ' + data.cont +
                                '</h5>',
                            allowEscapeKey: true,
                            allowOutsideClick: true,
                        })
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
        /**************************************************************************/
        $('.money').mask('000,000,000,000,000.00', {
            reverse: true
        });
        /**************************************************************************/
        $('#type_manager').on('change', function(e) {
            var type_service = e.target.value;
            $(".field").attr("style", "display:none");
            $('.input').val('');
            $('.input').removeAttr('required');
            $('.input').attr('disabled', 'disabled');
            switch (type_service) {
                case 'G':
                    $(".typeday").attr("style", "display:block");

                    $('#type_date').removeAttr('disabled');
                    $('#type_date').attr('required', true)
                    break;
            }
        });
        /**************************************************************************/
        $('#type_date').on('change', function(e) {
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
    </script>
@endsection
