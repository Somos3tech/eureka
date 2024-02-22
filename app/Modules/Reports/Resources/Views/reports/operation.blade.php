@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/sweetalert2.min.css') }}">
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
                    {!! Form::open() !!}
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-2">
                            <label><b>Tipo Gestión</b></label>
                            {!! form::select(
                                'type_service',
                                ['' => 'Seleccione Tipo Gestión...', 'basico' => 'Básica', 'masivo' => 'Masiva'],
                                null,
                                ['id' => 'type_service', 'class' => 'form-control'],
                            ) !!}
                        </div>

                        <div class="col-sm-3">
                            <label><b>Tipo Operación</b></label>
                            {!! form::select(
                                'type_operation',
                                [
                                    '' => 'Seleccione Tipo Operación..',
                                    'credito' => 'Crédito/Abono Generado',
                                    'debito' => 'Cargo Generado',
                                    'exonerado' => 'Exonerado Cobro',
                                    'reverso' => 'Reverso Pago',
                                ],
                                null,
                                ['id' => 'type_operation', 'class' => 'form-control'],
                            ) !!}
                        </div>

                        <div class="col-sm-2">
                            <label><b>Tipo Fecha</b></label>
                            {!! form::select(
                                'type_date',
                                ['' => 'Seleccione Tipo Fecha...', 'range' => 'Rango', 'month' => 'Mes/Año'],
                                null,
                                ['id' => 'type_date', 'class' => 'form-control'],
                            ) !!}
                        </div>

                        <div class="col-sm-3 month_date" style="display:none;">
                            <label><b>Fecha (Año/Mes)</b></label>
                            <div>
                                <input type="text" id="date" name="date" class="form-control date"
                                    placeholder="yyyy-mm" readonly />
                            </div>
                        </div>

                        <div class="col-sm-3 range_date" style="display:none;">
                            <label><b>Fecha Rango</b></label>
                            <div>
                                <div class="input-group">
                                    <input type="text" id="date_range" name="date_range" class="form-control daterange"
                                        placeholder="yyyy-mm-dd | yyyy-mm-dd" readonly />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12 p-3">
                            <center><a id=generate name=generate class="btn btn-sm btn-info" style="color:white;">Generar
                                    Reporte</a></center>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- Content-->
@endsection

@section('page-js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('/assets/js/vendor/sweetalert2.min.js') }}"></script>

    @toastr_js
    @toastr_render
    <script type="text/javascript">
        flatpickr(".daterange", {
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
        flatpickr(".date", {
            dateFormat: "Y-m",
            locale: {
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
        /******************************************************************************/
        /******************************************************************************/
        $('#type_date').on('change', function(e) {
            var type_date = e.target.value;

            if (type_date == 'range') {
                $(".month_date").attr("style", "display:none");
                $(".range_date").attr("style", "display:block");

                $('.daterange').removeAttr('disabled');
                $('.daterange').attr('required', true);

                $('.datepicker').attr('disabled', true);
                $('.datepicker').removeAttr('required');
            } else
            if (type_date == 'month') {
                $(".month_date").attr("style", "display:block");
                $(".range_date").attr("style", "display:none");

                $('.datepicker').removeAttr('disabled');
                $('.datepicker').attr('required', true);

                $('.daterange').attr('disabled', true);
                $('.daterange').removeAttr('required');
            } else {
                $(".month_date").attr("style", "display:none");
                $(".range_date").attr("style", "display:none");

                $('.datepicker').attr('disabled', true);
                $('.datepicker').removeAttr('required');

                $('.daterange').attr('disabled', true);
                $('.daterange').removeAttr('required');
            }
        });
        /**************************************************************************/
        $("#generate").click(function() {
            var type_service = $("#type_service").val();
            var type_operation = $("#type_operation").val();
            var type_date = $("#type_date").val();
            var date = $("#date").val();
            var date_range = $("#date_range").val();

            let data = {
                json: 1,
                type_operation: type_operation,
                type_service: type_service,
                type_date: type_date,
                date: date,
                date_range: date_range
            }
            var route = "{{ route('reports.operation.export') }}";

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
                    var uri = route + '?json=&type_operation=' + type_operation + '&type_service=' +
                        type_service + '&type_date=' + type_date + '&date=' + date + '&date_range=' +
                        date_range;
                    location.href = uri;
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
    </script>
@endsection
