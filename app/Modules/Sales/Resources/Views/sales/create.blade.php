@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/sweetalert2.min.css') }}">

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
    {!! Form::open([
        'id' => 'sales-create',
        'name' => 'sales-create',
        'route' => 'sales.store',
        'method' => 'POST',
        'files' => true,
    ]) !!}
    {{ csrf_field() }}
    <div class="row">
        <div class="col-sm-4 offset-4">
            <div class="card mb-8">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8  ">
                            {!! Form::text('find', null, [
                                'id' => 'find',
                                'class' => 'form-control text-center mayusc rif',
                                'placeholder' => 'Ingrese RIF',
                            ]) !!}
                        </div>

                        <div class="col-sm-4  ">
                            <button type="button" name="find" class="btn btn-sm btn-dark find">Consultar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row customer" style="display:none;">
        <div class="col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12   customer" style="display:none;">
                            <h5 class="mt-0 m-b-20 header-title customer"><b>Información Venta</b></h5>
                        </div>
                        <div class="col-sm-3 customer" style="display:none;">
                            <label for="customer_id" class="col-sm-12 col-form-label">Código</label>
                            {!! form::hidden('type_contract', 'basic', ['id' => 'type_contract']) !!}
                            {!! form::text('customer_id', null, [
                                'id' => 'customer_id',
                                'class' => 'form-control outlinenone',
                                'readonly' => 'readonly',
                                'value' => old('customer_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 customer" style="display:none;">
                            <label for="rif" class="col-sm-12 col-form-label">RIF</label>
                            {!! form::text('rif', null, [
                                'id' => 'rif',
                                'class' => 'form-control outlinenone',
                                'value' => old('rif'),
                                'readonly' => 'readonly',
                            ]) !!}
                        </div>

                        <div class="col-sm-7 customer" style="display:none;">
                            <label for="bussiness_name" class="col-sm-12 col-form-label">Nombre Comercial</label>
                            {!! form::text('business_name', null, [
                                'id' => 'business_name',
                                'class' => 'form-control outlinenone blank',
                                'value' => old('business_name'),
                                'readonly' => 'readonly',
                            ]) !!}
                        </div>

                        <div class="col-sm-3 customer" style="display:none;">
                            <label for="term_id" class="col-sm-12 col-form-label">Almacén Venta*</label>
                            {!! form::select('company_id', [], null, [
                                'id' => 'company_id',
                                'class' => 'form-control select2',
                                'value' => old('company_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-3 user customer" style="display:none;">
                            <label for="user_id" class="col-sm-12 col-form-label">Asesor / Asistente*</label>
                            {!! form::select('user_id', ['' => 'Seleccione Asesor/Asistente Venta...'], null, [
                                'id' => 'user_id',
                                'value' => old('user_id'),
                                'class' => 'form-control select2 user',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-3 customer" style="display:none;">
                            <label for="consultant_id" class="col-sm-12 col-form-label">Aliado Asociado*</label>
                            {!! form::select('consultant_id', ['' => 'Seleccione Aliado Asociado...'], null, [
                                'id' => 'consultant_id',
                                'value' => old('consultant_id'),
                                'class' => 'form-control select2',
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row customer" style="display:none;">
        <div class="col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12  customer" style="display:none;">
                            <h5 class="mt-0 m-b-20 header-title"><b>Información General Contrato</b></h5>
                        </div>

                        <div class="col-sm-2 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Banco*</b></label>
                            {!! Form::select('bank_id', ['' => 'Seleccione Banco...'], null, [
                                'id' => 'bank_id',
                                'class' => 'form-control',
                                'value' => old('bank_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Afiliación*</b></label>
                            {!! Form::select('dcustomer_id', ['' => 'Seleccione No. Afiliación...'], null, [
                                'id' => 'dcustomer_id',
                                'class' => 'form-control',
                                'value' => old('dcustomer_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-3  customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Modelo Equipo*</b></label>
                            {!! Form::select('modelterminal_id', ['' => 'Seleccione Modelo Equipo...'], null, [
                                'id' => 'modelterminal_id',
                                'class' => 'form-control available terminalvalue modelterminal',
                                'value' => old('modelterminal_id'),
                                'required' => 'required',
                            ]) !!}
                            <div id="total-available"></div>
                        </div>

                        <div class="col-sm-2   customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Operador</b></label>
                            {!! Form::select('operator_id', ['' => 'Seleccione Operador...'], null, [
                                'id' => 'operator_id',
                                'class' => 'form-control',
                                'value' => old('operator_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-3 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Planes VEPAGOS*</b></label>
                            {!! Form::select('term_id', ['' => 'Seleccione Plan VEPAGOS...'], null, [
                                'id' => 'term_id',
                                'class' => 'form-control',
                                'value' => old('term_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-12 customer" style="display:none;">
                            {!! form::label('Observaciones') !!}
                            {!! form::textarea('observation', null, [
                                'id' => 'observation',
                                'class' => 'form-control blank',
                                'value' => old('observation'),
                                'placeholder' =>
                                    'Ingrese sus observaciones si existe una prioridad con la gestión del punto de venta en caso contrario puede dejar en blanco',
                                'rows' => 2,
                                'maxlength' => 191,
                                'required' => 'required',
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row customer" style="display:none;">
        <div class="col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 customer" style="display:none;">
                            <h5 class="mt-0 m-b-20 header-title"><b>Información de Pago</b></h5>
                        </div>

                        <div class="col-sm-3 customer" style="display:none;">
                            <div class="col-sm-12">
                                <label for="date_value" class="col-sm-12 col-form-label"><b>Fecha Valor*</b></label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="i-calendar"></i></span>
                                    </div>
                                    <input id="date_value" name="date_value" type="text"
                                        class="form-control terminalvalue datepicker" value="{{ old('date_value') }}"
                                        placeholder="yyyy-mm-dd" data-toggle="datepicker" required>
                                </div><!-- input-group -->
                            </div>
                        </div>

                        <div class="col-sm-2 customer" style="display:none;">
                            <label for="currency_id" class="col-sm-12 col-form-label"><b>Divisa*</b></label>
                            {!! form::hidden('currency', null, ['id' => 'currency']) !!}
                            {!! form::select('currency_id', ['' => 'Seleccione Divisa...'], null, [
                                'id' => 'currency_id',
                                'class' => 'form-control terminalvalue',
                                'value' => old('currency_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2   customer" style="display: none;">
                            <label class="col-sm-12 col-form-label"><b>Tarifa Cambio*</b></label>
                            {!! form::text('dicom', null, [
                                'id' => 'dicom',
                                'class' => 'form-control money',
                                'placeholder' => 'Ingrese Tarifa Cambio',
                                'value' => old('dicom'),
                                'maxlength' => '20',
                                'readonly' => 'readonly',
                            ]) !!}
                            <div id="date_dicom" name="date_dicom"></div>
                        </div>

                        <div class="col-sm-2 amountu_display" style="display: none;">
                            <label class="col-sm-12 col-form-label"><b>Valor Equipo*</b></label>
                            {!! form::text('amount', null, [
                                'id' => 'amount',
                                'class' => 'form-control money amountu',
                                'placeholder' => 'Ingrese Valor Equipo',
                                'value' => old('amount'),
                                'maxlength' => '20',
                                'readonly' => 'readonly',
                            ]) !!}
                            <div id="date_amount" name="date_amount"></div>
                        </div>

                        <div class="col-sm-2 amountm_display" style="display: none;">
                            <label class="col-sm-12 col-form-label"><b>Valor Equipo*</b></label>
                            {!! form::select('amountm', [], null, [
                                'id' => 'amountm',
                                'value' => old('amountm'),
                                'class' => 'form-control amountm',
                            ]) !!}
                            <div id="date_amountm" name="date_amountm"></div>
                        </div>

                        <div class="col-sm-2   customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Forma Pago</b></label>
                            {!! Form::select('pmethod_id', ['' => 'Seleccione Forma de Pago...'], null, [
                                'id' => 'pmethod_id',
                                'class' => 'form-control',
                                'value' => old('payment_id'),
                            ]) !!}
                        </div>

                        <div class="col-sm-4   customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Referencia</b></label>
                            {!! Form::text('refere', null, [
                                'id' => 'refere',
                                'class' => 'form-control',
                                'value' => old('refere'),
                                'placeholder' => 'No. Referencia',
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row customer" style="display:none;">
        <div class="col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 customer" style="display:none;">
                            <h5 class="mt-0 m-b-20 header-title customer"><b>Documentos</b></h5>
                        </div>

                        <div class="col-sm-3 mb-2 customer" style="display:none;">
                            <div class="card text-left">
                                <div class="card-body">
                                    <center>
                                        <h6><b>Soporte Pago*</b></h6>
                                        <div id="upload-payment">
                                            <a href="#" data-toggle="modal" data-target="#uploadPaymentSale">
                                                <div id="image_payment" name="image_payment" data-toggle="tooltip"
                                                    data-placement="top" title="Clic x Cargar Soporte de Pago"><img
                                                        src="/assets/images/upload-pdf.png" width="35%"></div>
                                            </a>
                                        </div>
                                        {!! Form::hidden('payment_path', null, ['id' => 'payment_path']) !!}
                                        <div id="response-payment"></div>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row customer" style="display:none;">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12 mb-4 customer" style="display:none;">
                        <br>
                        <center><button id="submit" type="submit" class="btn btn-info" data-toggle="tooltip"
                                data-placement="top" title="Registrar Preafiliación">Registrar</button></center>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        @include('preafiliations::preafiliations.upload')
    @endsection

    @section('page-js')
        <script src="/assets/js/select2.min.js"></script>
        <script src="{{ asset('/assets/js/vendor/dropzone.min.js') }}"></script>
        <script src="{{ asset('/assets/js/vendor/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>

        @toastr_js
        @toastr_render

        <script type="text/javascript">
            flatpickr(".datepicker", {
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
                }
            });
            /**************************************************************************/
            Dropzone.options.paymentDropzone = {
                autoProcessQueue: true,
                maxFilesize: 2,

                init: function() {
                    var submitBtn = document.querySelector("#payment-dropzone");
                    myDropzone = this;

                    submitBtn.addEventListener("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        myDropzone.processQueue();
                    });
                    this.on('sending', function(file, xhr, formData) {
                        formData.append('rif', document.getElementById("rif").value);
                        formData.append('type_document', 'payment_sale');
                    });
                    this.on("success",
                        function(file, result) {
                            myDropzone.processQueue.bind(myDropzone)
                            document.getElementById("payment_path").value = result;
                            $("#image_payment").empty();
                            $("#image_payment").prepend(
                                "<img src='/assets/images/upload-success.png' width='50%'>");
                        });
                }
            };
            /**************************************************************************/
            $('.find').on('click', function() {
                formaRif(document.getElementById("find").value);
                var find = document.getElementById("find").value;
                if (find != '') {
                    $.get('/customers/find?data_customer=' + find, function(data) {

                        if (!data) {
                            $("#rif").val('');
                            $(".customer").attr("style", "display:none");
                            swal('', '<b>Cliente ya registrado en el Sistema o tiene un proceso de Preafiliación, Consulta a detalle.</b>',
                                'info');
                        } else {
                            $(".customer").attr("style", "display:block");
                            $("#customer_id").val(data.id);
                            $("#rif").val(data.rif);
                            $("#business_name").val(data.business_name);
                        }
                    });
                } else {
                    $(".customer").attr("style", "display:none");
                    swal('', 'Por favor Ingresar RIF de Comercio', 'warning');
                }
            });
            /**************************************************************************/
            $.get('/roles/getrole', function(data) {
                var user_id = data.user_id;
                var slug = data.slug;
                /**************************************************************************/
                $.get('/companies/select/zone-valid?wholesaler=0&slug=' + slug, function(data) {
                    $('#company_id').empty();
                    if (data.length != 1) {
                        $('#company_id').append("<option value=''>Seleccione Almacén Venta...</option>");
                    }
                    $.each(data, function(index, subCompanyObj) {
                        document.getElementById("company_id").disabled = false;
                        $('#company_id').append("<option value='" + subCompanyObj.id + "'>" +
                            subCompanyObj.description + "</option>");
                    });
                    $("#company_id option[value=" + {{ old('company_id') }} + "]").attr("selected", true);


                    var company = document.getElementById("company_id").value;
                    $.get('/users/select?slug=' + slug + '&company_id=' + company + '&user_id=' + user_id,
                        function(data) {
                            $('#user_id').empty();
                            if (data.length != 1) {
                                $('#user_id').append(
                                    "<option value=''>Seleccione Asesor Venta...</option>");
                            }

                            if (data.length >= 1 && (slug == 'assistant' || slug == 'preafiliation' ||
                                    slug == 'sales')) {
                                $.each(data, function(index, subUserObj) {
                                    $('#user_id').append("<option value='" + subUserObj.id + "'>" +
                                        subUserObj.description + "</option>");
                                });
                            }

                            $("#user_id option[value=" + {{ old('user_id') }} + "]").attr("selected",
                                true);
                        });
                    /**************************************************************************/
                    $.get('/consultants/select?user_id=' + user_id, function(data) {
                        $('#consultant_id').empty();
                        if (data.length > 1) {
                            $('#consultant_id').append(
                                "<option value=''>Seleccione Aliado Comercial...</option>");
                            $.each(data, function(index, subUserObj) {
                                $('#consultant_id').append("<option value='" + subUserObj.id +
                                    "'>" + subUserObj.description + "</option>");
                            });
                            $("#consultant_id option[value=" + {{ old('consultant_id') }} + "]").attr(
                                "selected", true);
                        } else {
                            document.getElementById("consultant_id").readonly = true;
                            $('#consultant_id').append(
                                "<option value=''>Ningún Aliado Comercial</option>");
                        }
                    });
                });
            });
            /**************************************************************************/
            $('#company_id').change(function(e) {
                $('#total-available').empty();
                var modelterminal = document.getElementById("modelterminal_id").value;
                var company = e.target.value;
                available(modelterminal, company, false);
                $.get('/roles/getrole', function(data) {
                    var user_id = data.user_id;
                    var slug = data.slug;
                    if (slug != 'preafiliation') {
                        $.get('/users/select?slug=' + slug + '&company_id=' + company + '&user_id=' + user_id,
                            function(data) {
                                $('#user_id').empty();
                                if (data.length != 1) {
                                    $('#user_id').append(
                                        "<option value=''>Seleccione Asesor Venta...</option>");
                                }
                                if (data.length > 0) {
                                    $.each(data, function(index, subUserObj) {
                                        $('#user_id').append("<option value='" + subUserObj.id +
                                            "'>" + subUserObj.description + "</option>");
                                    });
                                }
                                $("#user_id option[value=" + {{ old('user_id') }} + "]").attr("selected",
                                    true);

                                $.get('/consultants/select?user_id=' + user_id, function(data) {
                                    $('#consultant_id').empty();
                                    if (data.length > 1) {
                                        $('#consultant_id').append(
                                            "<option value=''>Seleccione Aliado Comercial...</option>"
                                        );
                                        $.each(data, function(index, subUserObj) {
                                            $('#consultant_id').append("<option value='" +
                                                subUserObj.id + "'>" + subUserObj
                                                .description + "</option>");
                                        });
                                        $("#consultant_id option[value=" +
                                            {{ old('consultant_id') }} + "]").attr(
                                            "selected", true);
                                    } else {
                                        document.getElementById("consultant_id").readonly = true;
                                        $('#consultant_id').append(
                                            "<option value=''>Ningún Aliado Comercial</option>");
                                    }
                                });
                            });
                    }
                });
            });
            /**************************************************************************/
            $('.user').on('change', function(e) {
                var user_id = e.target.value;
                $.get('/consultants/select?user_id=' + user_id, function(data) {
                    $('#consultant_id').empty();
                    if (data.length > 0) {
                        $('#consultant_id').append("<option value=''>Seleccione Aliado Comercial...</option>");
                        $.each(data, function(index, subUserObj) {
                            $('#consultant_id').append("<option value='" + subUserObj.id + "'>" +
                                subUserObj.description + "</option>");
                            $("#consultant_id option[value=" + {{ old('consultant_id') }} + "]")
                                .attr("selected", true);
                        });
                    } else {
                        document.getElementById("consultant_id").readonly = true;
                        $('#consultant_id').append("<option value=''>Ningún Aliado Comercial</option>");
                    }
                });
            });
            /**************************************************************************/
            $('#bank_id').change(function(e) {
                $.get('/dcustomers/select?customer_id=' + parseInt($("#customer_id").val()) + '&bank_id=' + e.target
                    .value,
                    function(data) {
                        $('#dcustomer_id').empty();
                        $('#dcustomer_id').append("<option value=''>Seleccione No. Afiliación...</option>");
                        $.each(data, function(index, subAffObj) {
                            $('#dcustomer_id').append("<option value='" + subAffObj.id + "'>" + subAffObj
                                .description + "</option>");
                        });
                        $("#dcustomer_id option[value=" + {{ old('dcustomer_id') }} + "]").attr("selected",
                            true);
                    });
            });
            /**************************************************************************/
            $('#currency_id').change(function(e) {
                $('#date_dicom').empty();
                currency_id = e.target.value;
                $.get('/currencies/find?currency_id=' + currency_id, function(data) {
                    document.getElementById("currency").value = data.abrev;
                });
                /************************************************************************/
                $.get('/currencyvalues/valueDycon?currency_id=' + currency_id, function(data) {
                    if (data) {
                        document.getElementById("dicom").value = data.dicom;
                        $('#date_dicom').empty();
                        if (currency_id > 1) {
                            $('#date_dicom').append(
                                '<span class="badge badge-pill badge-success p-2 m-1">Fecha: ' + data
                                .date_value + ' (Bs.)</span>');
                        } else {
                            $('#date_dicom').append(
                                '<span class="badge badge-pill badge-dark p-2 m-1">Fecha: No Aplica</span>');
                            document.getElementById("dicom").value = 0;
                        }
                    } else {
                        document.getElementById("dicom").value = 0;
                        if (currency_id > 1) {
                            toastr.info(
                                "No se encuentra Valor Cambio Divisa en el Sistema, Validar con Área encargada"
                            )
                        }
                    }
                });
            });
            /**************************************************************************/
            $('.terminalvalue').change(function() {
                $('#date_dicom').empty();
                currency_id = document.getElementById("currency_id").value;
                var date_value = document.getElementById("date_value").value;
                $.get('/currencies/find?currency_id=' + currency_id, function(data) {
                    document.getElementById("currency").value = data.abrev;
                });
                /**************************************************************************/
                $.get('/currencyvalues/valueDycon?currency_id=' + currency_id + '&date_value=' + date_value, function(
                    data) {
                    if (data) {
                        document.getElementById("dicom").value = data.dicom;
                        $('#date_dicom').empty();
                        if (currency_id > 1) {
                            $('#date_dicom').append(
                                '<span class="badge badge-pill badge-success p-2 m-1">Fecha: ' + data
                                .date_value + ' (Bs.)</span>');
                        } else {
                            $('#date_dicom').append(
                                '<span class="badge badge-pill badge-dark p-2 m-1">Fecha: No Aplica</span>');
                            document.getElementById("dicom").value = 0;
                        }
                    } else {
                        document.getElementById("dicom").value = 0;
                        if (currency_id > 1) {
                            toastr.info(
                                "No se encuentra Valor Cambio Divisa en el Sistema, Validar con Área encargada"
                            )
                        }
                    }
                });
                amountTotal();
            });
            /**************************************************************************/
            $('.available').on('change', function(e) {
                $('#total-available').empty();
                var modelterminal = e.target.value;
                var company = document.getElementById("company_id").value;
                available(modelterminal, company, true);
            });
            /**************************************************************************/
            function amountTotal() {
                var modelterminal_id = document.getElementById("modelterminal_id").value;
                var currency_id = document.getElementById("currency_id").value;
                var date_value = document.getElementById("date_value").value;

                $.get('/terminalvalues/get-amount?modelterminal_id=' + modelterminal_id + '&currency_id=' + currency_id +
                    '&date_value=' + date_value,
                    function(data) {
                        if (data.length == 1) {
                            $("#submit").css('display', 'block');
                            $(".amountu_display").css('display', 'block');
                            $(".amountm_display").css('display', 'none');

                            $('.amountu').removeAttr('disabled');
                            $('.amountu').attr('required', true);

                            $('.amountm').attr('disabled', 'disabled');
                            $('.amountm').removeAttr('required');

                            $.each(data, function(index, subAmountObj) {
                                if (currency_id == 1) {
                                    document.getElementById("amount").value = subAmountObj.local;
                                } else if (currency_id > 1) {
                                    document.getElementById("amount").value = subAmountObj.currency;
                                }
                                $('#date_amount').empty();
                                $('#date_amount').append(
                                    '<span class="badge badge-pill badge-success p-2 m-1">Fecha: ' +
                                    subAmountObj.date + ' (' + subAmountObj.currency_denomination + ')</span>');
                            });
                        } else
                        if (data.length > 1) {
                            $("#submit").css('display', 'block');
                            $(".amountu_display").css('display', 'none');
                            $(".amountm_display").css('display', 'block');

                            $('.amountu').attr('disabled', 'disabled');
                            $('.amountu').removeAttr('required');

                            $('.amountm').removeAttr('disabled');
                            $('.amountm').attr('required', true);

                            $('#amountm').empty();
                            $('#amountm').append("<option value=''>Seleccione Valor Terminal...</option>");

                            $.each(data, function(index, subAmountObj) {
                                if (currency_id == 1) {
                                    $('#amountm').append("<option value='" + subAmountObj.local + "'>" +
                                        subAmountObj.local + " - " + subAmountObj.description + "</option>");
                                } else
                                if (currency_id > 1) {
                                    $('#amountm').append("<option value='" + subAmountObj.currency + "'>" +
                                        subAmountObj.currency + " - " + subAmountObj.description + "</option>");
                                }
                                $('#date_amountm').empty();
                                $('#date_amountm').append('<span class="badge badge-pill badge-success p-2 m-1">' +
                                    subAmountObj.date + ' (' + subAmountObj.currency_denomination + ')</span>');
                            });
                        } else {
                            $("#submit").css('display', 'none');
                            $("#amountm option:selected").removeAttr("selected");
                            $(".amountu_display").css('display', 'none');
                            $(".amountm_display").css('display', 'none');

                            $('.amountu').removeAttr('disabled');
                            $('.amountu').attr('required', true);

                            $('.amountm').attr('disabled', 'disabled');
                            $('.amountm').removeAttr('required');
                        }

                        if (modelterminal_id != '' && currency_id != '' && data.length == 0) {
                            $('#date_amount').empty();
                            $('#date_amountm').empty();
                            $("#submit").css('display', 'none');
                            toastr.info(
                                "No se encuentra Valor de Venta de este Modelo y/ó Denominación de Divisa en el Sistema, Validar con Área encargada"
                            )
                        }
                    });
            }
            /************************************************************************/
            function cambiar() {
                var pdrs = document.getElementById('file').files[0].name;
                document.getElementById('info').innerHTML = pdrs;
            }

            /************************************************************************/
            function formaRif(rif) {
                if (rif) {
                    var parts = rif.split("-");

                    if (parts.length == 2) {
                        var index = parts[1].substr(-1);
                        parts[2] = index;
                        parts[1] = parts[1].slice(0, -1);
                        parts[1] = parts[1].padStart(8, '0');
                    } else {
                        if (parts.length > 2) {
                            if (parts[2] == "") {
                                var index = parts[1].substr(-1);
                                parts[2] = index;
                                parts[1] = parts[1].slice(0, -1);
                                parts[1] = parts[1].padStart(8, '0');
                            }
                        }
                    }
                }
                document.getElementById("find").value = parts.join("-");
            }
            /**************************************************************************/
            function available(modelterminal, company, available) {
                $.get('/terminals/totalAvailable?modelterminal_id=' + modelterminal + '&company_id=' + company, function(data) {
                    if (data > 0) {
                        $.get('/preafiliations/totalAvailable?modelterminal_id=' + modelterminal + '&company_id=' +
                            company + '&total_terminal=' + data,
                            function(data2) {
                                if (data2 > 0) {
                                    $("#submit").css('display', 'block');
                                    $('#total-available').append(
                                        '<span class="badge badge-pill badge-success p-2 m-1">Equipos Disponibles: ' +
                                        data2 + '</span>');
                                } else {
                                    $("#submit").css('display', 'none');
                                    $('#total-available').append(
                                        '<span class="badge badge-pill badge-danger p-2 m-1">Equipos Disponibles: ' +
                                        data2 + '</span>');
                                }
                            });
                    } else {
                        $("#submit").css('display', 'none');
                        $('#total-available').append(
                            '<span class="badge badge-pill badge-danger p-2 m-1">Equipos Disponibles: ' + 0 +
                            '</span>');
                        if (available == true) {
                            toastr.info("No se puede realizar Venta, ya que no hay Equipos Disponibles para Reservar")
                        }
                    }
                });
            }
        </script>

        @include('sales::sales.js')
    @endsection
