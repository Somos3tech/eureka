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
                    {!! Form::open([
                        'id' => 'form-support',
                        'route' => 'serviceSupport.invoice.store',
                        'method' => 'POST',
                        'files' => true,
                    ]) !!}
                    {{ csrf_field() }}

                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label class="col-sm-12 col-form-label">&nbsp;</label>
                            {!! form::text('find', null, [
                                'id' => 'find',
                                'class' => 'form-control text-center rif clear',
                                'placeholder' => 'Ingrese No. Cobro',
                            ]) !!}
                        </div>

                        <div class="col-sm-1">
                            <label class="col-sm-12 col-form-label">&nbsp;</label>
                            <button type="button" name="find"
                                class="btn btn-sm btn-fill btn-dark find">Consultar</button>
                        </div>

                        <div class="col-sm-1 invoice" style="display:none;">
                            <label for="contract_id" class="col-sm-12 col-form-label">Cont.</label>
                            {!! form::hidden('id', null, ['id' => 'id']) !!}
                            {!! form::hidden('fechpro_support', null, ['id' => 'fechpro_support']) !!}
                            {!! form::hidden('refere_support', null, ['id' => 'refere_support']) !!}
                            {!! form::hidden('payment_date_support', null, ['id' => 'payment_date_support']) !!}
                            {!! form::hidden('tipnot_support', null, ['id' => 'tipnot_support']) !!}
                            {!! form::hidden('currency_id_support', null, ['id' => 'currency_id_support']) !!}
                            {!! form::hidden('amount_support', null, ['id' => 'amount_support']) !!}
                            {!! form::hidden('free_support', null, ['id' => 'free_support']) !!}
                            {!! form::hidden('dicom_support', null, ['id' => 'dicom_support']) !!}
                            {!! form::hidden('status_support', null, ['id' => 'status_support']) !!}

                            {!! form::text('contract_id', null, [
                                'id' => 'contract_id',
                                'class' => 'form-control',
                                'placeholder' => 'Ingresar No. Contrato',
                                'readonly' => 'readonly',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 invoice" style="display:none;">
                            <label for="customer_id" class="col-sm-12 col-form-label">Código</label>
                            {!! form::text('customer_id', null, [
                                'id' => 'customer_id',
                                'class' => 'form-control',
                                'placeholder' => 'Ingresar Código',
                                'readonly' => 'readonly',
                                'value' => old('customer_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 invoice" style="display:none;">
                            <label for="rif" class="col-sm-12 col-form-label">RIF</label>
                            {!! form::text('rif', null, [
                                'id' => 'rif',
                                'class' => 'form-control',
                                'placeholder' => 'Ingresar RIF',
                                'readonly' => 'readonly',
                            ]) !!}
                        </div>

                        <div class="col-sm-4 invoice" style="display:none;">
                            <label for="bussiness_name" class="col-sm-12 col-form-label">Nombre Comercial</label>
                            {!! form::text('business_name', null, [
                                'id' => 'business_name',
                                'class' => 'form-control blank',
                                'placeholder' => 'Ingresar Nombre Comercial',
                                'readonly' => 'readonly',
                            ]) !!}
                        </div>

                        <div class="col-sm-12 invoice" style="display:none;"><br />
                            <table id="invoices-detail" name="invoices-detail"
                                class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>No. Cobro</center>
                                        </th>
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
                                            <center>Almacén</center>
                                        </th>
                                        <th>
                                            <center>Tipo Afiliación</center>
                                        </th>
                                        <th>
                                            <center>Modelo Terminal</center>
                                        </th>
                                        <th>
                                            <center>Método Pago</center>
                                        </th>
                                        <th>
                                            <center>No. Referencia</center>
                                        </th>
                                        <th>
                                            <center>Divisa</center>
                                        </th>
                                        <th>
                                            <center>Monto</center>
                                        </th>
                                        <th>
                                            <center>Descuento</center>
                                        </th>
                                        <th>
                                            <center>Dicom</center>
                                        </th>
                                        <th>
                                            <center>Soporte Adjunto</center>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="col-sm-2 invoice" style="display:none;">
                            <label for="type_service" class="col-sm-12 col-form-label">Tipo Cambio*</label>
                            {!! form::select('type_service', [], null, [
                                'id' => 'type_service',
                                'class' => 'form-control select2',
                                'placeholder' => 'Seleccione Cambio a Realizar...',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <!--Creado-->
                        <div class="col-sm-2 support created" style="display:none;">
                            <div class="col-sm-12">
                                <label for="fechpro" class="col-sm-12 col-form-label">Creado<small>*</small></label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                    <input id="fechpro" name="fechpro" type="text"
                                        class="form-control fechpro datepicker input" placeholder="yyyy-mm-dd"
                                        data-toggle="datepicker" readonly>
                                </div><!-- input-group -->
                            </div>
                        </div>

                        <!--Fecha Pago-->
                        <div class="col-sm-2 support paymentdate" style="display:none;">
                            <div class="col-sm-12">
                                <label for="payment_date" class="col-sm-12 col-form-label">Fecha
                                    Pago<small>*</small></label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                    <input id="payment_date" name="payment_date" type="text"
                                        class="form-control payment_date datepicker input" placeholder="yyyy-mm-dd"
                                        data-toggle="datepicker" readonly>
                                </div><!-- input-group -->
                            </div>
                        </div>

                        <div class="col-sm-3 support refer" style="display:none;">
                            <div class="col-sm-12">
                                <label for="refere" class="col-sm-12 col-form-label">Referencia<small>*</small></label>
                                <input id="refere" name="refere" type="text" class="form-control refere input"
                                    placeholder="Ingrese Referencia">
                            </div>
                        </div>

                        <div class="col-sm-4 support amounts" style="display:none;">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="currency_id" class="col-sm-12 col-form-label">Divisa<small>*</small></label>
                                    {!! form::select('currency_id', ['' => 'Seleccione Divisa...'], null, [
                                        'id' => 'currency_id',
                                        'class' => 'form-control currency_id input',
                                    ]) !!}
                                </div>

                                <div class="col-sm-6">
                                    <label for="amount" class="col-sm-12 col-form-label">Valor
                                        Equipo<small>*</small></label>
                                    <input id="amount" name="amount" type="text"
                                        class="form-control zero money blank amount input"
                                        placeholder="Ingrese Valor Terminal">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-2 support frees" style="display:none;">
                            <div class="col-sm-12">
                                <label for="free" class="col-sm-12 col-form-label">Descuento<small>*</small></label>
                                <input id="free" name="free" type="text"
                                    class="form-control money blank free input" placeholder="Ingrese Descuento">
                            </div>
                        </div>

                        <div class="col-sm-2 support dicoms" style="display:none;">
                            <div class="col-sm-12">
                                <label for="dicom" class="col-sm-12 col-form-label">Tárifa
                                    Dicom<small>*</small></label>
                                <input id="dicom" name="dicom" type="text"
                                    class="form-control money blank dicom input" placeholder="Ingrese Valor Dicom">
                            </div>
                        </div>

                        <div class="col-sm-3 support attachment" style="display:none;">
                            <div class="col-sm-12">
                                <label class="col-sm-12 col-form-label">Soporte Pago<small>*</small></label>
                                <input id="file" name="file" type="file" class="btn-secondary file input" />
                                <p>Formato Soportado: <b>PDF</b> Max: <b>10MB</b></p>
                            </div>
                        </div>

                        <div class="col-sm-10 support paymentmethod" style="display:none;">
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="payment_method" class="col-sm-12 col-form-label">Método Pago*</label>
                                    {!! form::select('payment_method', ['Seleccione Método Pago...'], null, [
                                        'id' => 'payment_method',
                                        'class' => 'form-control payment_method input select2',
                                    ]) !!}
                                </div>

                                <div class="col-sm-2 invoice_method" style="display:none;">
                                    <label for="currency_id"
                                        class="col-sm-12 col-form-label">Divisa<small>*</small></label>
                                    {!! form::select('currency_id', ['' => 'Seleccione Divisa...'], null, [
                                        'id' => 'currency_id',
                                        'class' => 'form-control currency2 input',
                                    ]) !!}
                                </div>

                                <div class="col-sm-2 amountu_display invoice_method" style="display: none;">
                                    <label class="col-sm-12 col-form-label">Valor Equipo<small>*</small></label>
                                    {!! form::text('amount', null, [
                                        'id' => 'amount',
                                        'class' => 'form-control change zero money blank amountu input',
                                        'placeholder' => 'Ingrese Valor Equipo',
                                        'maxlength' => '20',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group invoice" style="display:none;">
                        <div class="col-sm-12">
                            <center><button type="submit" class='btn btn-sm btn-info'
                                    name="Registrar">Actualizar</button></center>
                        </div>
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
    <script src="{{ asset('/assets/js/vendor/dropzone.min.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>

    @toastr_js
    @toastr_render

    <script type="text/javascript">
        $(document).ready(function() {
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
        /**************************************************************************/
        $('.find').on('click', function(e) {
            var find = document.getElementById("find").value;
            if (find != '') {
                $.get('/invoices/findInvoiceId?invoice_id=' + find, function(data) {
                    $(".support").attr("style", "display:none");
                    if (data.id > 0) {
                        $(".invoice").attr("style", "display:block");
                        $("#id").val(data.id);
                        $("#contract_id").val(data.contract_id);
                        $("#customer_id").val(data.customer_id);
                        $("#rif").val(data.rif);
                        $("#business_name").val(data.business_name);
                        $("#fechpro_support").val(data.fechpro);
                        $("#status_support").val(data.status_invoice);
                        $("#payment_date_support").val(data.payment_date);
                        $("#refere_support").val(data.refere);
                        $("#tipnot_support").val(data.tipnot);
                        $("#currency_id_support").val(data.currency_id);
                        $("#amount_support").val(data.amount);
                        $("#free_support").val(data.free);
                        $("#dicom_support").val(data.dicom);

                        $('#type_service').empty();
                        $('#type_service').append(
                            "<option value=''>Seleccione Cambio a Realizar...</option>");
                        $('#type_service').append("<option value='Created'>Fecha Generado</option>");
                        $('#type_service').append("<option value='PaymentDate'>Fecha Pago</option>");
                        $('#type_service').append("<option value='Refer'>Referencia</option>");
                        $('#type_service').append("<option value='Attachment'>Soporte de Pago</option>");
                        if (data.collection_id <= 0) {
                            $('#type_service').append("<option value='PaymentMethod'>Método Pago</option>");
                            $('#type_service').append("<option value='Amount'>Monto Venta</option>");
                        }

                        $('#type_service').append("<option value='Free'>Descuento</option>");
                        $('#type_service').append("<option value='Dicom'>Tarifa Cambio Divisa</option>");

                        $('#invoices-detail > tbody').empty();
                        var tbl = document.getElementById("invoices-detail");
                        var tblBody = document.createElement("tbody");
                        var fila = document.createElement("tr");

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data.id);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data.contract_id);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        let div = document.createElement('div');
                        div.innerHTML = data.status;
                        celda.appendChild(div);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data.fechpro);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data.company);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data.type_dcustomer);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data.modelterminal);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data.tipnot);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data.refere);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data.currency);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data.amount);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data.free);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data.dicom);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data.attachment);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        tblBody.appendChild(fila);
                        tbl.appendChild(tblBody);
                        tbl.setAttribute("border", "2");
                    } else {
                        $(".invoice").attr("style", "display:none");
                        $('#contracts-detail > tbody').empty();
                        $("#contract_id").val('');
                        $("#customer_id").val('');
                        $("#rif").val('');
                        $("#business_name").val('');
                        swal('', 'No se puede realizar Soporte a este Cobro ', 'info');
                    }
                });
            } else {
                $(".invoice").attr("style", "display:none");
                $('#contracts-detail > tbody').empty();
                $("#contract_id").val('');
                $("#customer_id").val('');
                $("#rif").val('');
                $("#business_name").val('');
                swal('', 'Por favor Ingresar No. Cobro', 'warning');
            }
        });
        /**************************************************************************/
        $('#type_service').on('change', function(e) {
            var type_service = e.target.value;
            $(".support").attr("style", "display:none");
            $('.input').removeAttr('required');
            $('.input').attr('disabled', 'disabled');
            switch (type_service) {
                case 'Created':
                    $(".created").attr("style", "display:block");
                    $('.fechpro').removeAttr('disabled');
                    $('.fechpro').attr('required', true);
                    var fechpro = document.getElementById("fechpro_support").value;
                    document.getElementById("fechpro").value = fechpro;
                    break;

                case 'PaymentDate':
                    $(".paymentdate").attr("style", "display:block");
                    $('.payment_date').removeAttr('disabled');
                    $('.payment_date').attr('required', true);
                    var paymentdate = document.getElementById("payment_date_support").value;
                    document.getElementById("payment_date").value = paymentdate;
                    break;

                case 'Refer':
                    $(".refer").attr("style", "display:block");
                    $('.refere').removeAttr('disabled');
                    $('.refere').attr('required', true);
                    var refer = document.getElementById("refere_support").value;
                    document.getElementById("refere").value = refer;
                    break;

                case 'Amount':
                    currency(local = null);

                    $(".amounts").attr("style", "display:block");
                    $('.amount').removeAttr('disabled');
                    $('.amount').attr('required', true);

                    $('.currency_id').removeAttr('disabled');
                    $('.currency_id').attr('required', true);

                    var amount = document.getElementById("amount_support").value;
                    var currency_id = document.getElementById("currency_id_support").value;

                    $(".currency_id option[value=" + currency_id + "]").attr("selected", true);
                    document.getElementById("amount").value = amount;
                    break;

                case 'Free':
                    $(".frees").attr("style", "display:block");
                    $('.free').removeAttr('disabled');
                    $('.free').attr('required', true);
                    var free = document.getElementById("free_support").value;
                    document.getElementById("free").value = free;
                    break;

                case 'Dicom':
                    $(".dicoms").attr("style", "display:block");
                    $('.dicom').removeAttr('disabled');
                    $('.dicom').attr('required', true);
                    var dicom = document.getElementById("dicom_support").value;
                    document.getElementById("dicom").value = dicom;
                    break;

                case 'Attachment':
                    $(".attachment").attr("style", "display:block");
                    $('.file').removeAttr('disabled');
                    $('.file').attr('required', true);
                    break;

                case 'PaymentMethod':
                    $(".paymentmethod, .invoice_method").attr("style", "display:block");
                    $('.payment_method').removeAttr('disabled');
                    $('.payment_method').attr('required', true);

                    $('.currency2').removeAttr('disabled');
                    $('.currency2').attr('required', true);

                    $('.amountu').removeAttr('disabled');
                    $('.amountu').attr('required', true);

                    paymentMethod();
                    currency(local = null);
                    $(".paymentmethod").css('display', 'block');
                    $('.amountu').attr('readonly', false);
                    $('.amountu').val('');
                    $('.amount').val('');

                    $(".currency2  option:selected").removeAttr("selected");
                    break;
            }
        });
        /**************************************************************************/
        $('#payment_method').on('change', function(e) {
            var payment_method = e.target.value;
            $(".invoice_method").css('display', 'block');

            $('.amountu').attr('readonly', false);
            $('.amountu').val('');
            $('.amount').val('');

            $(".currency2  option:selected").removeAttr("selected");

            switch (payment_method) {
                case 'Efectivo':
                    dte();
                    break;
                case 'Deposito':
                    dte();
                    break;
                case 'Transferencia':
                    dte();
                    break;
                case 'DTE':
                    dte();
                    break;
                case 'Postpago':
                    dte();
                    break;
                default:
                    break;
            }
        });
        /**************************************************************************/
        function dte() {
            currency(local = null);
        }
        /**************************************************************************/
        $('.change').keyup(function() {
            result = number_format((calculator() / 100), 2);
        });
        /**************************************************************************/
        function calculator() {
            var am = $('.amountu').val();
            var cp = $('.collect_partial').val();
            return am.replace(/[.,]/g, '');
        }
        /**************************************************************************/
        function paymentMethod() {
            $.get('/pmethods/select', function(data) {
                $('#payment_method').empty();
                $('#payment_method').append("<option value=''>Seleccione Método Pago...</option>");
                $.each(data, function(index, subPmethodObj) {
                    $('#payment_method').append("<option value='" + subPmethodObj.slug + "'>" +
                        subPmethodObj.description + "</option>");
                });
            });
        }
        /**************************************************************************/
        function currency(local) {
            if (local != '') {
                uri = '/currencies/select';
            } else {
                uri = '/currencies/select?local=N';
            }

            $.get(uri, function(data) {
                $('.currency_id, .currency2').empty();
                $('.currency_id, .currency2').append("<option value=''>Seleccione Divisa...</option>");
                $.each(data, function(index, subCurrencyObj) {
                    $('.currency_id, .currency2').append("<option value='" + subCurrencyObj.id + "'>" +
                        subCurrencyObj.abrev + "</option>");
                });
            });
        }
        /**************************************************************************/
        function number_format(amount, decimals) {
            amount += ''; // por si pasan un numero en vez de un string
            amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

            decimals = decimals || 0; // por si la variable no fue fue pasada

            // si no es un numero o es igual a cero retorno el mismo cero
            if (isNaN(amount) || amount === 0)
                return parseFloat(0).toFixed(decimals);

            // si es mayor o menor que cero retorno el valor formateado como numero
            amount = '' + amount.toFixed(decimals);

            var amount_parts = amount.split('.'),
                regexp = /(\d+)(\d{3})/;

            while (regexp.test(amount_parts[0]))
                amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

            return amount_parts.join('.');
        }
        /**************************************************************************/
        $('.money').mask(' 000,000,000,000.00', {
            reverse: true
        });
        /**************************************************************************/
        $('.zero').keyup(function() {
            if (this.value.charAt(0) != 0) {
                this.value = this.value;
            } else {
                this.value = this.value.slice(1);
            }
        });
        /**************************************************************************/
        /* Evento para cuando el usuario libera la tecla escrita dentro del input */
        $('.blank').blur(function() {
            /* Obtengo el valor contenido dentro del input */
            var value = $(this).val();

            /* Elimino todos los espacios en blanco que tenga la cadena delante y detrás */
            var value_without_space = $.trim(value);

            /* Cambio el valor contenido por el valor sin espacios */
            $(this).val(value_without_space);
        });
    </script>
@endsection
