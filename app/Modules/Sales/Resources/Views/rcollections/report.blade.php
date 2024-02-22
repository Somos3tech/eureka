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
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <h4 class="mt-0 m-b-30 header-title">{{ $identity }}</h4>

                                    <!-- Content-->
                                    {!! Form::open(['route' => 'rcollections.report.export', 'method' => 'POST']) !!}
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-sm-2 field typeday">
                                            <label for="type_date" class="col-sm-12"><b>Tipo Fecha*</b></label>
                                            {!! Form::select(
                                                'type_date',
                                                ['' => 'Seleccione Tipo Fecha...', 'date' => 'Fecha única', 'range' => 'Fecha Rango'],
                                                null,
                                                ['id' => 'type_date', 'class' => 'form-control input', 'required' => 'required'],
                                            ) !!}
                                        </div>

                                        <div class="col-sm-3 field range" style="display:none;">
                                            <label><b>Cobranza - Rango</b></label>
                                            <div>
                                                <div class="input-daterange input-group" id="date-range">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="i i-Calendar"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control input date_range"
                                                        id="date_range" name="date_range"
                                                        placeholder="yyyy-mm-dd | yyyy-mm-dd" data-toggle="datepicker"
                                                        readonly />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 field day" style="display:none;">
                                            <div class="col-sm-12">
                                                <label for="date_invoice"
                                                    class="col-sm-12"><b>Cobranza<small>*</small></b></label>
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="i i-Calendar"></i></span>
                                                    </div>
                                                    <input id="fechpro" name="fechpro" type="text"
                                                        class="form-control input datepicker fechpro"
                                                        placeholder="yyyy-mm-dd" data-toggle="datepicker" readonly>
                                                </div><!-- input-group -->
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <label for="bank_id" class="col-sm-12"><b>Banco*</b></label>
                                            {!! form::select('bank_id', ['' => 'Seleccione Banco...'], null, [
                                                'id' => 'bank_id',
                                                'class' => 'form-control select2',
                                                'required' => 'required',
                                            ]) !!}
                                        </div>

                                        <div class="col-sm-12"><br><br></div>

                                        <div class="col-sm-12 row justify-content-md-center">
                                            <label>&nbsp;</label>
                                            <center><button type="submit" href="#"
                                                    class='btn btn-sm btn-info'>Procesar</button></center>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <div class="col-md-12">
                                                        <div class="getBank" style="display:none;">
                                                            <h5><b>Balance Cobranza x Banco</b></h5>
                                                            <div id="echartPieBank" style="height: 300px;"></div>
                                                            <center>
                                                                <h5><b>
                                                                        Total Registros: <div id="total_bank"
                                                                            name="total_bank"></div>
                                                                        Monto Total($): <div id="amount_bank"
                                                                            name="amount_bank"></div>
                                                                    </b></h5>
                                                            </center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Content-->
                                </div>
                            </div>
                        </div>
                    </div><!-- end row -->
                </div>
            </div>
        </div>
    </div>
    <!-- Content-->
@endsection

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/sweetalert2.min.js') }}"></script>

    <script type="text/javascript">
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
        /******************************************************************************/
        $.get('/banks/select', function(data) {
            $('#bank_id').empty();
            $('#bank_id').append("<option value=''>Seleccione Banco...</option>");
            $.each(data, function(index, subBankObj) {
                $('#bank_id').append("<option value='" + subBankObj.id + "'>" + subBankObj.description +
                    "</option>");
            });
        });
        /****************************************************************************/
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
