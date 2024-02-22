@extends('layouts.compact-master')
@section('page-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/sweetalert2.min.css') }}">
    <link href="/assets/css/select2.min.css" rel="stylesheet" />
    @toastr_css
    <style>
        .outlinenone {
            outline: none;
            background-color: #ffffff;
            border: none;
        }

        .modal-lg {
            width: 750px;
        }
    </style>
@endsection

@section('main-content')
    <div class="breadcrumb">
        <h1>{{ $identity ?? 'Dashboard' }}</h1>

    </div>
    <!-- Separador -->
    <div class="separator-breadcrumb border-top"></div>

    <!-- Content -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    {!! Form::open(['id' => 'form', 'route' => 'operterminals.store', 'method' => 'POST']) !!}
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-12">
                            <h5><b>Consultar Cliente</b></h5>
                        </div>
                        <div class="col-sm-11">
                            <select class="search form-control form-control-rounded" id="search" name="search"></select>
                        </div>

                        <div class="col-sm-1">
                            <a href="#" name="find" class="btn btn-sm btn-fill btn-dark find">Consultar</a>
                        </div>
                        <div class="col-sm-12">
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 contract" style="display:none;">
                            <hr>
                        </div>
                        <div class="col-sm-2 contract" style="display:none;">
                            <label for="customer_id" class="col-sm-12"><b>Código</b></label>
                            {!! form::hidden('contract_id', null, [
                                'id' => 'contract_id',
                                'value' => old('contract_id'),
                                'required' => 'required',
                            ]) !!}
                            {!! form::text('customer_id', null, [
                                'id' => 'customer_id',
                                'class' => 'form-control',
                                'placeholder' => 'Ingresar Código',
                                'value' => old('customer_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 contract" style="display:none;">
                            <label for="rif" class="col-sm-12"><b>RIF</b></label>
                            {!! form::text('rif', null, [
                                'id' => 'rif',
                                'class' => 'form-control',
                                'placeholder' => 'Ingresar RIF',
                                'readonly' => 'readonly',
                            ]) !!}
                        </div>

                        <div class="col-sm-8 contract" style="display:none;">
                            <label for="bussiness_name" class="col-sm-12"><b>Nombre Comercial</b></label>
                            {!! form::text('business_name', null, [
                                'id' => 'business_name',
                                'class' => 'form-control blank',
                                'placeholder' => 'Ingresar Nombre Comercial',
                                'readonly' => 'readonly',
                            ]) !!}
                        </div>

                        <div class="col-sm-12 contract" style="display:none;">
                            <br>
                            <h4><b>Detalle Contrato</b></h4>
                        </div>

                        <div class="col-sm-12 contract" style="display:none;">
                            <table id="contracts-detail" name="contracts-detail"
                                class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>No. Contrato</center>
                                        </th>
                                        <th>
                                            <center>Status</center>
                                        </th>
                                        <th>
                                            <center>Creado</center>
                                        </th>
                                        <th>
                                            <center>Fecha Entrega</center>
                                        </th>
                                        <th>
                                            <center>Banco</center>
                                        </th>
                                        <th>
                                            <center>No. Afiliación</center>
                                        </th>
                                        <th>
                                            <center>Modelo Equipo</center>
                                        </th>
                                        <th>
                                            <center>Serial</center>
                                        </th>
                                        <th>
                                            <center>No. Terminal</center>
                                        </th>
                                        <th>
                                            <center>Plan Servicio</center>
                                        </th>
                                        <th>
                                            <center>Monto</center>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                            <hr>
                        </div>

                        <div class="col-sm-3 contract" style="display:none;">
                            <label for="type_operation" class="col-sm-12"><b>Tipo Operación<small>*</small></b></label>
                            {!! form::select('type_operation', ['' => 'Seleccione Operación...'], null, [
                                'id' => 'type_operation',
                                'class' => 'form-control',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-3 type_service" style="display:none;">
                            <label for="type_service" class="col-sm-12"><b>Tipo Suspensión<small>*</small></b></label>
                            {!! form::select(
                                'type_service',
                                ['' => 'Seleccione Tipo Suspensión...', 'temporal' => 'Temporal', 'definitivo' => 'Terminación Servicio'],
                                null,
                                ['id' => 'type_service', 'class' => 'form-control input type_service'],
                            ) !!}
                        </div>

                        <div class="col-sm-3 definitive" style="display:none;">
                            <div class="col-sm-12">
                                <label for="date_inactive" class="col-sm-12"><b>Fecha Suspensión<small>*</small></b></label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="i-Calendar"></i></span>
                                    </div>
                                    <input id="date_inactive" name="date_inactive" type="text"
                                        class="form-control input date_inactive datepicker" value="{{ old('date_value') }}"
                                        placeholder="yyyy-mm-dd" data-toggle="datepicker">
                                </div><!-- input-group -->
                            </div>
                        </div>

                        <div class="col-sm-3 temporal" style="display:none;">
                            <div class="col-sm-12">
                                <label for="date_reactive" class="col-sm-12"><b>Fecha
                                        Reactivación<small>*</small></b></label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="i-Calendar"></i></span>
                                    </div>
                                    <input id="date_reactive" name="date_reactive" type="text"
                                        class="form-control input date_reactive datepicker" value="{{ old('date_value') }}"
                                        placeholder="yyyy-mm-dd" data-toggle="datepicker">
                                </div><!-- input-group -->
                            </div>
                        </div>

                        <div class="col-sm-3 term" style="display:none;">
                            <label for="term_id" class="col-sm-12"><b>Plan<small>*</small></b></label>
                            {!! form::select('term_id', ['' => 'Seleccione Plan Servicio...'], null, [
                                'id' => 'term_id',
                                'class' => 'form-control input term_id',
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>

                        <div class="col-sm-12 contract" style="display:none;">
                            <hr>
                            <label class="col-sm-12"><b>Observaciones<small>*</small></b></label>
                            {!! form::textarea('observations', null, [
                                'id' => 'observations',
                                'class' => 'form-control blank',
                                'value' => old('observations'),
                                'placeholder' => 'Ingrese sus observaciones...',
                                'rows' => 2,
                                'maxlength' => 191,
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-12 operation" style="display:none;">
                            <hr>
                            <center><button type="submit" class='btn btn-sm btn-info submit'>Procesar Gestión</button>
                            </center>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- Content-->
    @endsection

    @section('page-js')
        <script src="{{ asset('/assets/js/vendor/dropzone.min.js') }}"></script>
        <script src="{{ asset('/assets/js/vendor/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>
        <script src="/assets/js/select2.min.js"></script>
        @toastr_js
        @toastr_render

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $(document).ready(function() {
                    $('#search').select2({
                        ajax: {
                            url: "{{ route('statements.customer') }}",
                            dataType: 'json',
                            delay: 100,
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(item) {
                                        return {
                                            text: item.description,
                                            id: parseInt(item.id),
                                        }
                                    })
                                };
                            },
                            cache: true
                        }
                    });
                    <?php
      if(isset($_GET['contract_id'])){
     ?>
                    findContract({{ (int) $_GET['contract_id'] }});
                    <?php
      }
    ?>
                });
                /****************************************************************************/
                flatpickr(".datepicker", {
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
                    }
                });
            });
            /****************************************************************************/
            $('.find').on('click', function(e) {
                var contract_id = document.getElementById("search").value;
                detailSearch(contract_id);
            });
            /****************************************************************************/
            function detailSearch(find) {
                $(".contract").attr("style", "display:none");
                $(".type_service").attr("style", "display:none");
                $(".temporal").attr("style", "display:none");
                $(".definitive").attr("style", "display:none");
                $(".term").attr("style", "display:none");
                $(".operation").attr("style", "display:none");
                $('.input').val('');
                $('#contracts-detail > tbody').empty();

                if (find != '') {
                    $.get('/statements/getInformationCustomer?find=' + find, function(data) {
                        if (data.length == 1) {
                            detail(data[0]);
                        } else {
                            $(".contract").attr("style", "display:none");
                            $('#contracts-detail > tbody').empty();
                            $("#contract_id").val('');
                            $("#customer_id").val('');
                            $("#rif").val('');
                            $("#business_name").val('');
                            swal('', 'No se encontro un registro en el Sistema', 'info');
                        }
                    });
                } else {
                    $(".contract").attr("style", "display:none");
                    $('#contracts-detail > tbody').empty();
                    $("#contract_id").val('');
                    $("#customer_id").val('');
                    $("#rif").val('');
                    $("#business_name").val('');
                    swal('', 'Por favor Ingresar No.contrato y Tipo de búsqueda', 'warning');
                }
            }
            /****************************************************************************/
            function detail(data) {
                $(".contract").attr("style", "display:block");
                $("#contract_id").val(parseInt(data.contract_id));
                $("#customer_id").val(data.customer_id);
                $("#rif").val(data.rif);
                $("#business_name").val(data.business_name);
                /****************************************************************************/
                $('#type_operation').empty();
                $('#type_operation').append("<option value=''>Seleccione Operación...</option>");

                if (data.statusc == 'Cancelado' || data.statusc == 'Suspendido') {
                    $('#type_operation').append("<option value='activacion'>Activar Servicio</option>");
                } else {
                    $('#type_operation').append("<option value='suspension'>Suspender Servicio</option>");
                    $('#type_operation').append("<option value='cambio'>Cambio Plan</option>");
                }

                var cont = 0;

                $('#contracts-detail > tbody').empty();
                var tbl = document.getElementById("contracts-detail");
                var tblBody = document.createElement("tbody");
                var fila = document.createElement("tr");

                var celda = document.createElement("td");
                var center = document.createElement("center");
                var textoCelda = document.createTextNode(data.contract_id);
                center.appendChild(textoCelda);
                celda.appendChild(center);
                fila.appendChild(celda);

                var celda = document.createElement("td");
                let div = document.createElement('div');
                div.innerHTML = data.statusc;
                celda.appendChild(div);
                fila.appendChild(celda);

                var celda = document.createElement("td");
                var center = document.createElement("center");
                var textoCelda = document.createTextNode(data.created);
                center.appendChild(textoCelda);
                celda.appendChild(center);
                fila.appendChild(celda);

                var celda = document.createElement("td");
                var center = document.createElement("center");
                var textoCelda = document.createTextNode(data.posted);
                center.appendChild(textoCelda);
                celda.appendChild(center);
                fila.appendChild(celda);

                var celda = document.createElement("td");
                var center = document.createElement("center");
                var textoCelda = document.createTextNode(data.bank);
                center.appendChild(textoCelda);
                celda.appendChild(center);
                fila.appendChild(celda);

                var celda = document.createElement("td");
                var center = document.createElement("center");
                var textoCelda = document.createTextNode(data.affiliate_number);
                center.appendChild(textoCelda);
                celda.appendChild(center);
                fila.appendChild(celda);

                var celda = document.createElement("td");
                var center = document.createElement("center");
                var textoCelda = document.createTextNode(data.modelterminal);
                center.appendChild(textoCelda);
                celda.appendChild(center);
                fila.appendChild(celda);

                var celda = document.createElement("td");
                var center = document.createElement("center");
                var textoCelda = document.createTextNode(data.terminal);
                center.appendChild(textoCelda);
                celda.appendChild(center);
                fila.appendChild(celda);

                var celda = document.createElement("td");
                var center = document.createElement("center");
                var textoCelda = document.createTextNode(data.nropos);
                center.appendChild(textoCelda);
                celda.appendChild(center);
                fila.appendChild(celda);

                var celda = document.createElement("td");
                var center = document.createElement("center");
                var textoCelda = document.createTextNode(data.term);
                center.appendChild(textoCelda);
                celda.appendChild(center);
                fila.appendChild(celda);

                var celda = document.createElement("td");
                var center = document.createElement("center");
                var textoCelda = document.createTextNode(parseFloat(data.term_amount).toFixed(2));
                center.appendChild(textoCelda);
                celda.appendChild(center);
                fila.appendChild(celda);

                tblBody.appendChild(fila);
                tbl.appendChild(tblBody);
                tbl.setAttribute("border", "2");
            }
            /****************************************************************************/
            $('.zero').keyup(function() {
                if (this.value.charAt(0) != 0) {
                    this.value = this.value;
                } else {
                    this.value = this.value.slice(1);
                }
            });
            /****************************************************************************/
            $('.blank').blur(function() {
                /* Obtengo el valor contenido dentro del input */
                var value = $(this).val();

                /* Elimino todos los espacios en blanco que tenga la cadena delante y detrás */
                var value_without_space = $.trim(value);

                /* Cambio el valor contenido por el valor sin espacios */
                $(this).val(value_without_space);
            });
            /****************************************************************************/
            $('#type_service').change(function(e) {
                var type_service = e.target.value;
                $('#date_inactive').removeAttr('readonly');
                $('#date_inactive').removeAttr('disabled');
                $('#date_inactive').attr('required', true);

                switch (type_service) {
                    case 'definitivo':
                        $(".temporal").attr("style", "display:none");
                        $(".definitive").attr("style", "display:block");

                        break;
                    case 'temporal':
                        $(".definitive").attr("style", "display:block");
                        $(".temporal").attr("style", "display:block");

                        $('#date_reactive').attr('readonly', true);
                        $('#date_reactive').removeAttr('disabled');
                        break;

                    default:
                        $(".temporal").attr("style", "display:none");
                        $(".definitive").attr("style", "display:none");
                        break;
                }
            });
            /****************************************************************************/
            $('#type_operation').change(function(e) {
                var contract_id = document.getElementById("contract_id").value;
                var type_operation = e.target.value;

                $('.input').val('');
                $(".temporal").attr("style", "display:none");
                $(".term").attr("style", "display:none");
                $(".definitive").attr("style", "display:none");
                $(".operation").attr("style", "display:none");
                switch (type_operation) {
                    case 'suspension':
                        typeOperation();
                        $(".operation").attr("style", "display:block");
                        $(".type_service").attr("style", "display:block");

                        $('.type_service').removeAttr('disabled');
                        $('.type_service').attr('required', true);
                        break;
                    case 'activacion':
                        typeOperation();
                        $(".operation").attr("style", "display:block");
                        $(".type_service").attr("style", "display:none");
                        break;
                    case 'cambio':
                        typeOperation();
                        $(".operation").attr("style", "display:block");
                        $(".temporal").attr("style", "display:none");
                        $(".definitive").attr("style", "display:none");
                        $(".term").attr("style", "display:block");
                        $(".type_service").attr("style", "display:none");

                        $('.term_id').removeAttr('disabled');
                        $('.term_id').attr('required', true);
                        break;

                    default:
                        typeOperation();
                        $(".operation").attr("style", "display:none");
                        $(".type_service").attr("style", "display:none");
                        break;
                }
            });
            /****************************************************************************/
            function typeOperation() {
                $('.input').attr('disabled', 'disabled');
                $('.input').removeAttr('required');
            }
            /****************************************************************************/
            $.get('/terms/select?type_condition=Fijo', function(data) {
                $('#term_id').empty();
                $('#term_id').append("<option value=''>Seleccione Plan Servicios...</option>");

                $.each(data, function(index, subTermObj) {
                    $('#term_id').append("<option value='" + subTermObj.id + "'>" + subTermObj.description +
                        "</option>");
                });
                $("#term_id option[value=" + {{ old('term_id') }} + "]").attr("selected", true);
            });
            /****************************************************************************/
            $('.money').mask('000,000,000,000,000.00', {
                reverse: true
            });
        </script>
    @endsection
