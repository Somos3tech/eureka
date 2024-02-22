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
    <!-- Separador -->
    <div class="separator-breadcrumb border-top"></div>

    <!-- Content -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    {!! Form::open(['id' => 'form', 'route' => 'operations.store', 'method' => 'POST']) !!}
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
                        <div class="col-sm-2 contract" style="display:none;">
                            <label for="customer_id" class="col-sm-12">Código</label>
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
                            <label for="rif" class="col-sm-12">RIF</label>
                            {!! form::text('rif', null, [
                                'id' => 'rif',
                                'class' => 'form-control',
                                'placeholder' => 'Ingresar RIF',
                                'readonly' => 'readonly',
                            ]) !!}
                        </div>

                        <div class="col-sm-4 contract" style="display:none;">
                            <label for="bussiness_name" class="col-sm-12">Nombre Comercial</label>
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
                                            <center>Condición Comercial</center>
                                        </th>
                                        <th>
                                            <center>Monto</center>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                            <hr>
                        </div>

                        <div class="col-sm-2 contract" style="display:none;">
                            <label for="date_value" class="col-sm-12 col-form-label"><b>Tipo
                                    Operación<small>*</small></b></label>
                            {!! form::select(
                                'type_operation',
                                [
                                    '' => 'Seleccione Operación...',
                                    'credito' => 'Crédito Cobro',
                                    'debito' => 'Generar Cobro',
                                    'reverso' => 'Reverso Deuda',
                                    'exoneracion' => 'Exoneración Deuda',
                                    'anulacion' => 'Anular Cobro',
                                ],
                                null,
                                ['id' => 'type_operation', 'class' => 'form-control', 'required' => 'required'],
                            ) !!}
                        </div>

                        <div class="col-sm-12 others" style="display:none;">
                            <hr>
                            <h4><b>Detalle Cobro Servicios</b></h4>
                        </div>

                        <div class="col-sm-12  debit" style="display:none;">
                            <hr>
                            <h4><b>Registrar Cobro Servicio</b></h4>
                        </div>

                        <div class="col-sm-2 debit" style="display:none;">
                            <div class="col-sm-12">
                                <label for="date_value"
                                    class="col-sm-12 col-form-label"><b>Fecha<small>*</small></b></label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="i-calendar"></i></span>
                                    </div>
                                    <input id="fechpro" name="fechpro" type="text"
                                        class="form-control input datepicker" value="{{ old('date_value') }}"
                                        placeholder="yyyy-mm-dd" data-toggle="datepicker" required>
                                </div><!-- input-group -->
                            </div>
                        </div>
                        <div class="col-sm-2 debit" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Tipo Operación<small>*</small></b></label>
                            {!! form::select(
                                'tipnot',
                                [
                                    '' => 'Seleccione Tipo Pago...',
                                    'Efectivo' => 'Efectivo',
                                    'Transferencia' => 'Transferencia',
                                    'Custodia' => 'Custodia',
                                ],
                                null,
                                ['id' => 'tipnot', 'class' => 'form-control input', 'disabled' => 'disabled'],
                            ) !!}
                        </div>
                        <div class="col-sm-2 debit" style="display: none;">
                            <label class="col-sm-12 col-form-label"><b>Valor<small>*</small></b></label>
                            {!! form::text('amount', null, [
                                'id' => 'amount',
                                'class' => 'form-control money input blank',
                                'placeholder' => 'Ingrese Valor Servicio',
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>

                        <div class="col-sm-6 debit" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Referencia<small>*</small></b></label>
                            {!! form::text('refere', null, [
                                'id' => 'refere',
                                'class' => 'form-control input blank',
                                'placeholder' => 'Ingresar Referencia Cobro',
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>


                        <div class="col-sm-12 others" style="display:none;">
                            <hr>
                            <table id="invoices-detail" name="invoices-detail"
                                class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>No. Cobro</center>
                                        </th>
                                        <th>
                                            <center>Generado</center>
                                        </th>
                                        <th>
                                            <center>Status</center>
                                        </th>
                                        <th>
                                            <center>Descripción</center>
                                        </th>
                                        <th>
                                            <center>Monto</center>
                                        </th>
                                        <th>
                                            <center>Referencia</center>
                                        </th>
                                        <th>
                                            <center>Acción</center>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="col-sm-12 others-credit" style="display:none;">
                            <hr>
                            <table id="invoices-detail2" name="invoices-detail2"
                                class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>No. Cobro</center>
                                        </th>
                                        <th>
                                            <center>Generado</center>
                                        </th>
                                        <th>
                                            <center>Status</center>
                                        </th>
                                        <th>
                                            <center>Fecha</center>
                                        </th>
                                        <th>
                                            <center>Cta Contable</center>
                                        </th>
                                        <th>
                                            <center>Monto</center>
                                        </th>
                                        <th>
                                            <center>Tasa Cambio</center>
                                        </th>
                                        <th>
                                            <center>Monto Bs.</center>
                                        </th>
                                        <th>
                                            <center>Referencia</center>
                                        </th>
                                        <th>
                                            <center>Acción</center>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="col-sm-12 contract" style="display:none;">
                            <hr>
                            <label class="col-sm-12 col-form-label"><b>Observaciones<small>*</small></b></label>
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

                        <div class="col-sm-12 operation" style="display:none;">
                            <hr>
                            <center><button type="submit" class='btn btn-sm btn-info'>Procesar Gestión</button></center>
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
                    detailSearch({{ (int) $_GET['contract_id'] }});
                    <?php
        }
      ?>
                });
            });
            datepicker();
            /****************************************************************************/
            $('.find').on('click', function(e) {
                var contract_id = document.getElementById("search").value;
                detailSearch(contract_id);
            });
            /****************************************************************************/
            function contractId(contract_id) {
                $.get('/contracts/findContract?find=' + contract_id + '&type_find=contract', function(data) {
                    swal.close()
                    detail(data[0]);
                });
            }
            /****************************************************************************/
            function detailSearch(contract_id) {
                $(".contract").attr("style", "display:none");
                $(".others").attr("style", "display:none");
                $(".debit").attr("style", "display:none");
                $(".operation").attr("style", "display:none");
                $(".others-credit").attr("style", "display:none");

                $('.input').attr('disabled', 'disabled');
                $('.input').removeAttr('required');

                $('#contracts-detail > tbody').empty();
                $('#invoices-detail > tbody').empty();
                $('#invoices-detail2 > tbody').empty();
                $('#type_operation').val('');
                $('#tipnot').val('');


                //  var type_find = document.getElementById("type_find").value;
                if (contract_id != '') {
                    $.get('/statements/getInformationCustomer?find=' + contract_id, function(data) {
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
                    swal('', 'Por favor Ingresar registro de Búsqueda', 'info');
                }
            }
            /****************************************************************************/
            function detail(data) {
                $(".contract").attr("style", "display:block");
                $("#contract_id").val(parseInt(data.contract_id));
                $("#customer_id").val(data.customer_id);
                $("#rif").val(data.rif);
                $("#business_name").val(data.business_name);

                var cont = 0;

                $('#contracts-detail > tbody').empty();
                var tbl = document.getElementById("contracts-detail");
                var tblBody = document.createElement("tbody");
                var fila = document.createElement("tr");

                var celda = document.createElement("td");
                var textoCelda = document.createTextNode(data.contract_id);
                celda.appendChild(textoCelda);
                fila.appendChild(celda);

                var celda = document.createElement("td");
                let div = document.createElement('div');
                div.innerHTML = data.statusc;
                celda.appendChild(div);
                fila.appendChild(celda);

                var celda = document.createElement("td");
                var textoCelda = document.createTextNode(data.created);
                celda.appendChild(textoCelda);
                fila.appendChild(celda);

                var celda = document.createElement("td");
                var textoCelda = document.createTextNode(data.posted);
                celda.appendChild(textoCelda);
                fila.appendChild(celda);

                var celda = document.createElement("td");
                var textoCelda = document.createTextNode(data.bank);
                celda.appendChild(textoCelda);
                fila.appendChild(celda);

                var celda = document.createElement("td");
                var textoCelda = document.createTextNode(data.affiliate_number);
                celda.appendChild(textoCelda);
                fila.appendChild(celda);

                var celda = document.createElement("td");
                var textoCelda = document.createTextNode(data.modelterminal);
                celda.appendChild(textoCelda);
                fila.appendChild(celda);

                var celda = document.createElement("td");
                var textoCelda = document.createTextNode(data.terminal);
                celda.appendChild(textoCelda);
                fila.appendChild(celda);

                var celda = document.createElement("td");
                var textoCelda = document.createTextNode(data.nropos);
                celda.appendChild(textoCelda);
                fila.appendChild(celda);

                var celda = document.createElement("td");
                var textoCelda = document.createTextNode(data.term);
                celda.appendChild(textoCelda);
                fila.appendChild(celda);

                var celda = document.createElement("td");
                var textoCelda = document.createTextNode(parseFloat(data.term_amount).toFixed(2));
                celda.appendChild(textoCelda);
                fila.appendChild(celda);

                tblBody.appendChild(fila);
                tbl.appendChild(tblBody);
                tbl.setAttribute("border", "2");
            }
            /****************************************************************************/
            function typeOperation() {
                $(".others").attr("style", "display:none");
                $(".debit").attr("style", "display:none");
                $('.input').attr('disabled', 'disabled');
                $('.input').removeAttr('required');
            }
            /****************************************************************************/
            $('#type_operation').change(function(e) {
                var contract_id = document.getElementById("contract_id").value;
                var type_operation = e.target.value;
                switch (type_operation) {
                    case 'debito':
                        $(".operation").attr("style", "display:block");
                        $(".debit").attr("style", "display:block");
                        $(".others").attr("style", "display:none");
                        $(".others-credit").attr("style", "display:none");
                        $('.input').removeAttr('disabled');
                        $('.input').attr('required', true);
                        break;
                    case 'credito':
                        typeOperation();
                        $(".operation").attr("style", "display:block");
                        $(".others").attr("style", "display:none");
                        detailInvoiceServiceCredit(contract_id, type_operation);
                        break;
                    case 'exoneracion':
                        typeOperation();
                        $(".operation").attr("style", "display:block");
                        $(".others-credit").attr("style", "display:none");
                        detailInvoiceService(contract_id, type_operation);
                        break;
                    case 'reverso':
                        typeOperation();
                        $(".operation").attr("style", "display:block");
                        $(".others-credit").attr("style", "display:none");
                        detailInvoiceService(contract_id, type_operation);
                        break;
                    case 'anulacion':
                        typeOperation();
                        $(".operation").attr("style", "display:block");
                        $(".others-credit").attr("style", "display:none");
                        detailInvoiceService(contract_id, type_operation);
                        break;
                    default:
                        typeOperation();
                        $(".operation").attr("style", "display:none");
                        break;
                }
            });
            /****************************************************************************/
            function detailInvoiceService(contract_id, type_operation) {
                $.get('/invoices/findService?contract_id=' + contract_id + '&type_operation=' + type_operation, function(data) {
                    if (data.length > 0) {
                        $(".others").attr("style", "display:block");
                        $('#invoices-detail > tbody').empty();
                        var tbl = document.getElementById("invoices-detail");
                        var tblBody = document.createElement("tbody");

                        $.each(data, function(index, subInvoiceObj) {
                            var fila = document.createElement("tr");

                            var celda = document.createElement("td");
                            var textoCelda = document.createTextNode(subInvoiceObj.invoice_id);
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            var celda = document.createElement("td");
                            var textoCelda = document.createTextNode(subInvoiceObj.fechpro);
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            var celda = document.createElement("td");
                            let div = document.createElement('div');
                            div.innerHTML = subInvoiceObj.status;
                            celda.appendChild(div);
                            fila.appendChild(celda);

                            var celda = document.createElement("td");
                            var textoCelda = document.createTextNode(subInvoiceObj.type_invoice);
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            if (subInvoiceObj.amount != null) {
                                var collect_amount = subInvoiceObj.amount;
                            } else {
                                var collect_amount = 0;
                            }

                            var celda = document.createElement("td");
                            var textoCelda = document.createElement("INPUT");
                            textoCelda.setAttribute("id", "register_amount[]");
                            textoCelda.setAttribute("name", "register_amount[]");
                            textoCelda.setAttribute("type", "text");
                            textoCelda.setAttribute("class", "form-control money");
                            textoCelda.setAttribute("readonly", true);
                            textoCelda.value = parseFloat(collect_amount).toFixed(2);
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            var celda = document.createElement("td");
                            var textoCelda = document.createElement("INPUT");
                            textoCelda.setAttribute("id", "register_refere[]");
                            textoCelda.setAttribute("name", "register_refere[]");
                            textoCelda.setAttribute("type", "text");
                            textoCelda.setAttribute("class", "form-control");
                            textoCelda.setAttribute("readonly", true);
                            textoCelda.value = subInvoiceObj.refere;
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            var celda = document.createElement("td");
                            var textoCelda = document.createElement("INPUT");
                            textoCelda.setAttribute("id", "invoice_id[]");
                            textoCelda.setAttribute("name", "invoice_id[]");
                            textoCelda.setAttribute("type", "checkbox");
                            textoCelda.setAttribute("class", "form-control invoice_id");
                            textoCelda.setAttribute("onclick", "check()");
                            textoCelda.value = subInvoiceObj.invoice_id;
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            tblBody.appendChild(fila);
                            tbl.appendChild(tblBody);
                            tbl.setAttribute("border", "2");
                        });
                    } else {
                        $(".others").attr("style", "display:none");
                        swal('', 'No hay registro en el Sistema de Cobros x Servicios', 'info');
                    }
                });
            }
            /****************************************************************************/
            function detailInvoiceServiceCredit(contract_id, type_operation) {
                $.get('/invoices/findService?contract_id=' + contract_id + '&type_operation=' + type_operation, function(data) {
                    if (data.length > 0) {
                        $(".others-credit").attr("style", "display:block");
                        $('#invoices-detail2 > tbody').empty();
                        var tbl = document.getElementById("invoices-detail2");
                        var tblBody = document.createElement("tbody");

                        $.each(data, function(index, subInvoiceObj) {
                            var fila = document.createElement("tr");

                            var celda = document.createElement("td");
                            var textoCelda = document.createTextNode(subInvoiceObj.invoice_id);
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            var celda = document.createElement("td");
                            var textoCelda = document.createTextNode(subInvoiceObj.fechpro);
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            var celda = document.createElement("td");
                            let div = document.createElement('div');
                            div.innerHTML = subInvoiceObj.status;
                            celda.appendChild(div);
                            fila.appendChild(celda);

                            var celda = document.createElement("td");
                            var textoCelda = document.createElement("INPUT");
                            textoCelda.setAttribute("id", "fechpro" + index);
                            textoCelda.setAttribute("name", "fechpro[]");
                            textoCelda.setAttribute("type", "text");
                            textoCelda.setAttribute("readonly", true);
                            textoCelda.setAttribute("class", "form-control fechpro");
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            var celda = document.createElement("td");
                            var textoCelda = document.createElement('select');
                            textoCelda.setAttribute("id", "acconcept" + index);
                            textoCelda.setAttribute("name", "acconcept[]");
                            textoCelda.setAttribute("class", "form-control acconcept");
                            var oEle = document.createElement('option');
                            var oTxt = document.createTextNode('Seleccione Concepto Contable...');
                            oEle.appendChild(oTxt);
                            textoCelda.appendChild(oEle);

                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            $.get('/acconcepts/select?filter=collection', function(data) {
                                $.each(data, function(index, subAcconceptObj) {
                                    $('.acconcept').append("<option value='" + subAcconceptObj
                                        .id + "'>" + subAcconceptObj.description +
                                        "</option>");
                                });
                            });

                            var celda = document.createElement("td");
                            var textoCelda = document.createElement("INPUT");
                            textoCelda.setAttribute("id", "amount" + index);
                            textoCelda.setAttribute("name", "amount[]");
                            textoCelda.setAttribute("type", "text");
                            textoCelda.setAttribute("class", "form-control amount");
                            textoCelda.setAttribute("readonly", true);
                            textoCelda.value = parseFloat(subInvoiceObj.amount).toFixed(2);
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);


                            var celda = document.createElement("td");
                            var textoCelda = document.createElement("INPUT");
                            textoCelda.setAttribute("id", "register_currencyvalue" + index);
                            textoCelda.setAttribute("name", "register_currencyvalue[]");
                            textoCelda.setAttribute("type", "text");
                            textoCelda.setAttribute("onchange", "check()");
                            textoCelda.setAttribute("pattern", "^[a-zA-Z0-9\.]*$");
                            textoCelda.value = parseFloat(subInvoiceObj.currencyvalue).toFixed(2);
                            textoCelda.setAttribute("class", "form-control currencyvalue");
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            var celda = document.createElement("td");
                            var textoCelda = document.createElement("INPUT");
                            textoCelda.setAttribute("id", "register_amount" + index);
                            textoCelda.setAttribute("name", "register_amount[]");
                            textoCelda.setAttribute("type", "text");
                            textoCelda.setAttribute("readonly", true);
                            textoCelda.setAttribute("class", "form-control money register_amount");
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            var celda = document.createElement("td");
                            var textoCelda = document.createElement("INPUT");
                            textoCelda.setAttribute("id", "register_refere" + index);
                            textoCelda.setAttribute("name", "register_refere[]");
                            textoCelda.setAttribute("type", "text");
                            textoCelda.setAttribute("class", "form-control");
                            textoCelda.value = '';
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            var celda = document.createElement("td");
                            var textoCelda = document.createElement("INPUT");
                            textoCelda.setAttribute("id", "invoice_id" + index);
                            textoCelda.setAttribute("name", "invoice_id[]");
                            textoCelda.setAttribute("type", "checkbox");
                            textoCelda.setAttribute("class", "form-control invoice_id");
                            textoCelda.setAttribute("onchange", "check()");
                            textoCelda.value = subInvoiceObj.invoice_id;
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            tblBody.appendChild(fila);
                            tbl.appendChild(tblBody);
                            tbl.setAttribute("border", "2");
                        });
                    } else {
                        $(".others-credit").attr("style", "display:none");
                        swal('', 'No hay registro en el Sistema de Cobros x Servicios', 'info');
                    }
                });
            }
            /****************************************************************************/
            $.get('/acconcepts/select?filter=collection', function(data) {
                $.each(data, function(index, subAcconceptObj) {
                    $('.acconcept').append("<option value='" + subAcconceptObj.id + "'>" + subAcconceptObj
                        .description + "</option>");
                });
            });
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
            function datepicker() {
                flatpickr(".datepicker", {
                    locale: {
                        firstDayOfWeek: 1,
                        weekdays: {
                            shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                            longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                        },
                        months: {
                            shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov',
                                'Dic'
                            ],
                            longhand: ['Enero', 'Febrero', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                                'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                            ],
                        },
                    }
                });
            }
            /****************************************************************************/
            function format(variable) {
                var format = document.getElementById(variable);

                if (format.value != '') {
                    change = format.value;
                    change = change.replace(',', '');
                } else {
                    change = 1;
                }
                format.value = fNumber.go(parseFloat(change).toFixed(2));
            }
            /****************************************************************************/
            function check() {
                var register_currencyvalue = $('.currencyvalue');
                var amount = $('.amount');
                var check = $('.invoice_id');
                var register_amount = $('.register_amount');

                for (var i = 0; i < check.length; i++) {
                    fechpro = document.getElementById('fechpro' + i);

                    if (check[i].checked) {
                        fechpro.classList.add('datepicker');
                        currencyvalue = register_currencyvalue[i].value;
                        currencyvalue = currencyvalue.replace(',', '');

                        register_amount = document.getElementById('register_amount' + i);
                        // register_amount.value = fNumber.go((parseFloat(amount[i].value) * parseFloat(currencyvalue)) * 100);
                        //MODIFICACION DEL DIA 19/11/2021 09:26
                        var multipli = parseFloat(amount[i].value) * parseFloat(currencyvalue);
                        register_amount.value = Number.parseFloat(multipli).toFixed(2);
                        //
                        var variable = "register_currencyvalue" + i;
                        format(variable);
                    }
                }
                datepicker();
            }

            /****************************************************************************/
            $('.money').mask('000,000,000,000,000.00', {
                reverse: true
            });
            /****************************************************************************/
            var fNumber = {
                sepMil: ",", // separador para los miles
                sepDec: '.', // separador para los decimales
                formatear: function(num) {
                    num += '';
                    var splitStr = num.split('.');
                    var splitLeft = splitStr[0];
                    var splitRight = splitStr.length > 1 ? this.sepDec + splitStr[1] : '';
                    var regx = /(\d+)(\d{3})/;

                    while (regx.test(splitLeft)) {
                        splitLeft = splitLeft.replace(regx, '$1' + this.sepMil + '$2');
                    }
                    return this.simbol + splitLeft + splitRight;
                },
                go: function(num, simbol) {
                    this.simbol = simbol || '';
                    return this.formatear(num);
                }
            }
        </script>
    @endsection
