@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @toastr_css
    <style>
        .error {
            background-color: #FDCDCD;
        }

        .outlinenone {
            outline: none;
            background-color: #ffffff;
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
                    {!! Form::open(['id' => 'form-invoice']) !!}
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-2">
                            <label for="type_invoice" class="col-sm-12"><b>Tipo*</b></label>
                            <!--, 'I'=> 'Cobranza'-->
                            {!! form::select(
                                'type_invoice',
                                ['' => 'Seleccione Tipo Cobranza...', 'P' => 'Pronostico', 'I' => 'Cobranza'],
                                null,
                                ['id' => 'type_invoice', 'class' => 'form-control select2', 'required' => 'required'],
                            ) !!}
                        </div>

                        <div class="col-sm-2">
                            <label for="type_service" class="col-sm-12"><b>Serv. Cobranza*</b></label>
                            {!! form::select(
                                'type_service',
                                ['' => 'Seleccione Servicio Cobranza...', 'D' => 'Diaria', 'Q' => 'Quincenal', 'M' => 'Mensual'],
                                null,
                                ['id' => 'type_service', 'class' => 'form-control select2', 'required' => 'required'],
                            ) !!}
                        </div>

                        <div class="col-sm-2 field biweekly" style="display:none;">
                            <label for="type_biweekly" class="col-sm-12"><b>Quincena</b></label>
                            {!! form::select(
                                'type_biweekly',
                                ['' => 'Seleccione Quincena...', '1' => 'Primera Quincena', '2' => 'Segunda Quincena'],
                                null,
                                ['id' => 'type_biweekly', 'class' => 'form-control select2'],
                            ) !!}
                        </div>

                        <div class="col-sm-2 field typeday" style="display:none;">
                            <label for="type_date" class="col-sm-12"><b>Tipo Fecha*</b></label>
                            {!! Form::select(
                                'type_date',
                                ['' => 'Seleccione Tipo Fecha...', 'date' => 'Fecha única', 'range' => 'Fecha Rango'],
                                null,
                                ['id' => 'type_date', 'class' => 'form-control input'],
                            ) !!}
                        </div>

                        <div class="col-sm-3 field months" style="display:none;">
                            <label for="fechpro" class="col-sm-12"><b>Cobranza<small>*</small></b></label>
                            <div class="input-daterange input-group" id="date-range">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="i i-Calendar"></i></span>
                                </div>
                                <input id="date_invoice" name="date_invoice" type="text"
                                    class="form-control input datepickerm date_invoice" placeholder="yyyy-mm"
                                    data-toggle="datepicker" readonly>
                            </div>
                        </div>

                        <div class="col-sm-3 field range" style="display:none;">
                            <label><b>Cobranza - Rango</b></label>
                            <div>
                                <div class="input-daterange input-group" id="date-range">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="i i-Calendar"></i></span>
                                    </div>
                                    <input type="text" class="form-control input date_range" id="date_range"
                                        name="date_range" placeholder="yyyy-mm-dd | yyyy-mm-dd" data-toggle="datepicker"
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
                                        class="form-control input datepicker fechpro" placeholder="yyyy-mm-dd"
                                        data-toggle="datepicker" readonly>
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
                            <center><a href="#" class='btn btn-sm btn-info' id="procesar"
                                    name="procesar">Procesar</a></center>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-sm-12">
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <div class="accordion" id="accordionRightIcon">
                            <div class="card-header header-elements-inline">
                                <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                    <a data-toggle="collapse" class="ext-default echartPie1View"
                                        href="#accordion-item-icons-3">
                                        <span><i class="i-Data-File-Chart ul-accordion__font"> </i></span> Distribución
                                        Cobranza Pendiente
                                    </a>
                                </h6>
                            </div>
                            <div id="accordion-item-icons-3" class="collapse" data-parent="#accordionRightIcon">
                                <div id="echartPie" style="height: 300px;"></div>
                                <center>
                                    <h5><b>
                                            Total Registros: <div id="total_pending" name="total_pending"></div>
                                            Monto Total($): <div id="amount_pending" name="amount_pending"></div>
                                        </b></h5>
                                </center>
                            </div>
                            <div class="card-header header-elements-inline">
                                <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                    <a data-toggle="collapse" class="echartPie4View" class="text-default collapsed"
                                        href="#accordion-item-icons-0">
                                        <span><i class="i-Data-File-Chart ul-accordion__font"> </i></span> Distribución
                                        Clientes Plan Servicios
                                    </a>
                                </h6>
                            </div>
                            <div id="accordion-item-icons-0" class="collapse " data-parent="#accordionRightIcon">
                                <div class="card-body">
                                    <div id="echartPie4" style="height: 300px;"></div>
                                    <center>
                                        <h5><b>
                                                Total Registros: <div id="total_term" name="total_term"></div>
                                                Monto Total($): <div id="amount_term" name="amount_term"></div>
                                            </b></h5>
                                    </center>
                                </div>
                            </div>
                            <div class="card-header header-elements-inline">
                                <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                    <a data-toggle="collapse" class="echartPie2View" class="text-default collapsed"
                                        href="#accordion-item-icons-1">
                                        <span><i class="i-Data-File-Chart ul-accordion__font"> </i></span> Distribución
                                        Clientes Cobro Diario
                                    </a>
                                </h6>
                            </div>
                            <div id="accordion-item-icons-1" class="collapse" data-parent="#accordionRightIcon">
                                <div class="card-body">
                                    <div id="echartPie2" style="height: 300px;"></div>
                                    <center>
                                        <h5><b>
                                                Total Registros: <div id="total_daily" name="total_daily"></div>
                                                Monto Total($): <div id="amount_daily" name="amount_daily"></div>
                                            </b></h5>
                                    </center>
                                </div>
                            </div>
                            <div class="card-header header-elements-inline">
                                <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                    <a data-toggle="collapse" class="echartPie3View" class="text-default collapsed"
                                        href="#accordion-item-icons-2">
                                        <span><i class="i-Data-File-Chart ul-accordion__font"> </i></span> Distribución
                                        Clientes Cobro Mensual
                                    </a>
                                </h6>
                            </div>
                            <div id="accordion-item-icons-2" class="collapse " data-parent="#accordionRightIcon">
                                <div class="card-body">
                                    <div id="echartPie3" style="height: 300px;"></div>
                                    <center>
                                        <h5><b>
                                                Total Registros: <div id="total_monthly" name="total_monthly"></div>
                                                Monto Total($): <div id="amount_monthly" name="amount_monthly"></div>
                                            </b></h5>
                                    </center>
                                </div>
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
        <script src="{{ asset('assets/js/vendor/echarts.min.js') }}"></script>
        <script src="{{ asset('assets/js/es5/echart.options.min.js') }}"></script>
        @toastr_js
        @toastr_render

        <script type="text/javascript">
            $(document).ready(function() {
                $.get('/banks/select', function(data) {
                    $('#bank_id').empty();
                    $('#bank_id').append("<option value=''>Seleccione Banco...</option>");
                    $.each(data, function(index, subBankObj) {
                        $('#bank_id').append("<option value='" + subBankObj.id + "'>" + subBankObj
                            .description + "</option>");
                    });
                });
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

            flatpickr(".datepickerm", {
                dateFormat: "Y-m",
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
            /****************************************************************************/
            $('#type_biweekly').on('change', function(e) {

            });
            /****************************************************************************/
            $('#type_service').on('change', function(e) {
                var type_service = e.target.value;
                $(".field").attr("style", "display:none");

                $('.input').removeAttr('required');
                $('.input').attr('disabled', 'disabled');
                switch (type_service) {
                    case 'D':
                        $(".typeday").attr("style", "display:block");

                        $('#type_date').removeAttr('disabled');
                        $('#type_date').attr('required', true)
                        break;

                    case 'M':
                        $(".months").attr("style", "display:block");

                        $('.date_invoice').removeAttr('disabled');
                        $('.date_invoice').attr('required', true);
                        break;

                    case 'Q':
                        $(".months").attr("style", "display:block");

                        $('.date_invoice').removeAttr('disabled');
                        $('.date_invoice').attr('required', true);

                        $(".biweekly").attr("style", "display:block");

                        $('#type_biweekly').removeAttr('disabled');
                        $('#type_biweekly').attr('required', true);
                        break;
                }
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
            /****************************************************************************/
            $('#procesar').on('click', function() {
                showLoading();

                var bank_id = document.getElementById("bank_id").value;
                var type_service = document.getElementById("type_service").value;
                var type_invoice = document.getElementById("type_invoice").value;
                var type_date = document.getElementById("type_date").value;
                var type_biweekly = document.getElementById("type_biweekly").value;
                var fechpro = document.getElementById("fechpro").value;
                var date_invoice = document.getElementById("date_invoice").value;
                var date_range = document.getElementById("date_range").value;

                var route = "{{ route('services.store') }}";
                var token = "{{ csrf_token() }}";

                let data = {
                    "type_service": type_service,
                    "type_invoice": type_invoice,
                    "type_date": type_date,
                    "type_biweekly": type_biweekly,
                    "date_invoice": date_invoice,
                    "fechpro": fechpro,
                    "date_range": date_range,
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
                        swal('', data.message, data.action);
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
            /****************************************************************************/
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
            /****************************************************************************/
            $('.echartPie1View').on('click', function() {

                $.get('/statements/getTotalServicePending', function(data) {
                    var total = 0;
                    var amount = 0;

                    var echartElemPie = document.getElementById('echartPie');

                    if (echartElemPie) {
                        var arr = [];

                        var arrayLength = data.length;
                        for (var i = 0; i < arrayLength; i++) {
                            var item = {
                                value: data[i].total,
                                name: data[i].bank_name + ' (Monto: $' + new Intl.NumberFormat("en-IN")
                                    .format(data[i].amount) + ')'
                            };
                            arr.push(item);
                            amount = parseFloat(amount) + parseFloat(data[i].amount != null ? data[i].amount :
                                0);
                            total = total + parseInt(data[i].total != null ? data[i].total : 0);
                        }

                        var echartPie = echarts.init(echartElemPie);
                        echartPie.setOption({
                            color: ['#CF4A2F', '#53CF2F', '#D6C246', '#92222F', '#225C99', '#3B2299',
                                '#99224D', '#A98A78', '#47551E', '#05050B', '#69D646', '#46C0D6',
                                '#D6469F'
                            ],
                            tooltip: {
                                show: true,
                                backgroundColor: 'rgba(0, 0, 0, .8)'
                            },
                            series: [{
                                name: 'Distribución Deudas',
                                type: 'pie',
                                radius: '60%',
                                center: ['50%', '50%'],
                                data: arr,
                                itemStyle: {
                                    emphasis: {
                                        shadowBlur: 10,
                                        shadowOffsetX: 0,
                                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                                    }
                                }
                            }]
                        });
                        $(window).on('resize', function() {
                            setTimeout(function() {
                                echartPie.resize();
                            }, 500);
                        });
                    } // Chart in Dashboard version 1
                    document.getElementById("total_pending").innerHTML = '<b>' + total + '</b>';
                    document.getElementById("amount_pending").innerHTML = '<b>$ ' + new Intl.NumberFormat(
                        "en-IN").format(amount) + '</b>';
                });
            });
            $('.echartPie2View').on('click', function() {
                $.get('/statements/getTotalServiceCustomer?type_invoice=D', function(data) {
                    var total = 0;
                    var amount = 0;
                    var echartElemPie2 = document.getElementById('echartPie2');

                    if (echartElemPie2) {
                        var arr = [];

                        var arrayLength = data.length;
                        for (var i = 0; i < arrayLength; i++) {
                            var item = {
                                value: data[i].total,
                                name: data[i].bank_name + ' (Monto: $' + new Intl.NumberFormat("en-IN")
                                    .format(data[i].amount) + ')'
                            };
                            arr.push(item);
                            amount = parseFloat(amount) + parseFloat(data[i].amount != null ? data[i].amount :
                                0);
                            total = total + parseInt(data[i].total != null ? data[i].total : 0);
                        }

                        var echartPie2 = echarts.init(echartElemPie2);
                        echartPie2.setOption({
                            color: ['#CF4A2F', '#53CF2F', '#D6C246', '#92222F', '#225C99', '#3B2299',
                                '#99224D', '#A98A78', '#47551E', '#05050B', '#69D646', '#46C0D6',
                                '#D6469F'
                            ],
                            tooltip: {
                                show: true,
                                backgroundColor: 'rgba(0, 0, 0, .8)'
                            },
                            series: [{
                                name: 'Distribución Clientes Cobro Diario',
                                type: 'pie',
                                radius: '60%',
                                center: ['50%', '50%'],
                                data: arr,
                                itemStyle: {
                                    emphasis: {
                                        shadowBlur: 10,
                                        shadowOffsetX: 0,
                                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                                    }
                                }
                            }]
                        });
                        $(window).on('resize', function() {
                            setTimeout(function() {
                                echartPie2.resize();
                            }, 500);
                        });
                    } // Chart in Dashboard version 1
                    document.getElementById("total_daily").innerHTML = '<b>' + total + '</b>';
                    document.getElementById("amount_daily").innerHTML = '<b>$ ' + new Intl.NumberFormat("en-IN")
                        .format(amount) + '</b>';
                });
            });
            $('.echartPie3View').on('click', function() {
                $.get('/statements/getTotalServiceCustomer?type_invoice=M', function(data) {
                    var total = 0;
                    var amount = 0;

                    var echartElemPie3 = document.getElementById('echartPie3');

                    if (echartElemPie3) {
                        var arr = [];

                        var arrayLength = data.length;
                        for (var i = 0; i < arrayLength; i++) {
                            var item = {
                                value: data[i].total,
                                name: data[i].bank_name + ' (Monto: $' + new Intl.NumberFormat("en-IN")
                                    .format(data[i].amount) + ')'
                            };
                            arr.push(item);
                            amount = parseFloat(amount) + parseFloat(data[i].amount != null ? data[i].amount :
                                0);
                            total = total + parseInt(data[i].total != null ? data[i].total : 0);
                        }

                        var echartPie3 = echarts.init(echartElemPie3);
                        echartPie3.setOption({
                            color: ['#CF4A2F', '#53CF2F', '#D6C246', '#92222F', '#225C99', '#3B2299',
                                '#99224D', '#A98A78', '#47551E', '#05050B', '#69D646', '#46C0D6',
                                '#D6469F'
                            ],
                            tooltip: {
                                show: true,
                                backgroundColor: 'rgba(0, 0, 0, .8)'
                            },
                            series: [{
                                name: 'Distribución Clientes Cobro Mensual',
                                type: 'pie',
                                radius: '60%',
                                center: ['50%', '50%'],
                                data: arr,
                                itemStyle: {
                                    emphasis: {
                                        shadowBlur: 10,
                                        shadowOffsetX: 0,
                                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                                    }
                                }
                            }]
                        });
                        $(window).on('resize', function() {
                            setTimeout(function() {
                                echartPie3.resize();
                            }, 500);
                        });
                    } // Chart in Dashboard version 1
                    document.getElementById("total_monthly").innerHTML = '<b>' + total + '</b>';
                    document.getElementById("amount_monthly").innerHTML = '<b>$ ' + new Intl.NumberFormat(
                        "en-IN").format(amount) + '</b>';

                });
            });
            $('.echartPie4View').on('click', function() {
                $.get('/contracts/getContractActive', function(data) {
                    var total = 0;
                    var amount = 0;
                    var echartElemPie4 = document.getElementById('echartPie4');
                    if (echartElemPie4) {
                        var arr = [];

                        var arrayLength = data.length;
                        for (var i = 0; i < arrayLength; i++) {
                            var item = {
                                value: data[i].total,
                                name: data[i].term_name + ' (' + data[i].type_invoice + ')' + ' (Monto: $' +
                                    new Intl.NumberFormat("en-IN").format(parseFloat(data[i].amount) *
                                        parseFloat(data[i].total)) + ')'
                            };
                            arr.push(item);
                            amount = parseFloat(amount) + (parseFloat(data[i].amount) * parseFloat(data[i]
                                .total));
                            total = total + parseInt(data[i].total != null ? data[i].total : 0);
                        }

                        var echartPie4 = echarts.init(echartElemPie4);
                        echartPie4.setOption({
                            color: ['#CF4A2F', '#D6C246', '#92222F', '#225C99', '#47551E', '#05050B',
                                '#69D646', '#46C0D6', '#D6469F'
                            ],
                            tooltip: {
                                show: true,
                                backgroundColor: 'rgba(0, 0, 0, .8)'
                            },
                            series: [{
                                name: 'Distribución Clientes Plan Servicio',
                                type: 'pie',
                                radius: '60%',
                                center: ['50%', '50%'],
                                data: arr,
                                itemStyle: {
                                    emphasis: {
                                        shadowBlur: 10,
                                        shadowOffsetX: 0,
                                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                                    }
                                }
                            }]
                        });
                        $(window).on('resize', function() {
                            setTimeout(function() {
                                echartPie4.resize();
                            }, 500);
                        });
                    } // Chart in Dashboard version 1
                    document.getElementById("total_term").innerHTML = '<b>' + total + '</b>';
                    document.getElementById("amount_term").innerHTML = '<b>$ ' + new Intl.NumberFormat("en-IN")
                        .format(amount) + '</b>';
                });
            });
            /****************************************************************************/
            /*$.get('/statements/getTotalServiceCustomer?type_invoice=Q', function(data) {
              var total = 0;
              var amount = 0;

              $('#statements-biweekly > tbody').empty();
              var tbl = document.getElementById("statements-biweekly");
              var tblBody = document.createElement("tbody");
                $.each(data, function(index, subStatementObj) {
                  amount= parseFloat(amount) + parseFloat(subStatementObj.amount != null ? subStatementObj.amount : 0);
                  total = total + parseInt(subStatementObj.total != null ? subStatementObj.total : 0);

                  var fila = document.createElement("tr");

                  var celda = document.createElement("td");
                  var textoCelda = document.createTextNode(subStatementObj.bank_name);
                  celda.appendChild(textoCelda);
                  fila.appendChild(celda);
                  var celda = document.createElement("td");
                  var center = document.createElement("center");
                  var textoCelda = document.createTextNode(subStatementObj.total);
                  center.appendChild(textoCelda);
                  celda.appendChild(center);
                  fila.appendChild(celda);

                  var celda = document.createElement("td");
                  var textoCelda = document.createTextNode("$ "+new Intl.NumberFormat("en-IN").format(subStatementObj.amount));
                  celda.appendChild(textoCelda);
                  fila.appendChild(celda);

                  tblBody.appendChild(fila);
                  tbl.appendChild(tblBody);
                  tbl.setAttribute("border", "2");
                });
              document.getElementById("total_biweekly").innerHTML = '<b>'+total+'</b>';
              document.getElementById("amount_biweekly").innerHTML = '<b>$ '+ parseFloat(amount).toFixed(2)+'</b>';
            });*/
        </script>
    @endsection
