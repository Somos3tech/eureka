@extends('layouts.compact-master')

@section('page-css')
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
                    {!! Form::open(['name' => 'form', 'route' => 'collections.store', 'method' => 'POST']) !!}
                    {{ csrf_field() }}

                    <div class="col-sm-12">
                        <h4 class="mt-0 m-b-30 header-title"><b>Información Cliente</b></h4>
                        <div class="form-group row">
                            <div class="col-sm-12 text-right">
                                <a href="javascript:window.history.back();" title="Volver" class="btn btn-sm btn-warning"
                                    style="color:white;"> Volver</a>&nbsp;
                            </div>

                            <div class="col-sm-2">
                                <label for="find" class="col-sm-12 col-form-label">No. Cobro</label>
                                {!! form::text('find', $_GET['invoice_id'], [
                                    'id' => 'find',
                                    'class' => 'form-control text-center rif clear',
                                    'placeholder' => 'Ingrese No. Cobro',
                                ]) !!}
                            </div>

                            <div class="col-sm-1">
                                <label class="col-sm-12 col-form-label">&nbsp;</label>
                                <button type="button" name="find" class="btn btn-sm btn-info find">Consultar</button>
                            </div>

                            <div class="col-sm-2 detail" style="display: none;">
                                <label for="customer_id" class="col-sm-12 col-form-label">Código</label>
                                {!! form::hidden('view', $_GET['view'], ['id' => 'view', 'class' => 'form-control']) !!}
                                {!! form::hidden('route', $_GET['route'], ['id' => 'route', 'class' => 'form-control']) !!}
                                {!! form::hidden('company_id', $_GET['company_id'], ['id' => 'company_id']) !!}
                                {!! form::hidden('type_contract', $_GET['type_contract'], ['id' => 'type_contract']) !!}
                                {!! form::text('customer_id', null, [
                                    'id' => 'customer_id',
                                    'class' => 'form-control outlinenone',
                                    'placeholder' => 'Código',
                                    'disabled' => 'disabled',
                                ]) !!}
                            </div>

                            <div class="col-sm-2 detail" style="display: none;">
                                <label for="rif" class="col-sm-12 col-form-label">RIF</label>
                                {!! form::text('rif', null, [
                                    'id' => 'rif',
                                    'class' => 'form-control outlinenone',
                                    'placeholder' => 'RIF',
                                    'disabled' => 'disabled',
                                ]) !!}
                            </div>

                            <div class="col-sm-5 detail" style="display: none;">
                                <label for="bussiness_name" class="col-sm-12 col-form-label">Nombre Comercial</label>
                                {!! form::text('business_name', null, [
                                    'id' => 'business_name',
                                    'class' => 'form-control outlinenone',
                                    'placeholder' => 'Nombre Comercio',
                                    'disabled' => 'disabled',
                                ]) !!}
                            </div>

                            <div class="col-sm-2 detail" style="display: none;">
                                <label for="state" class="col-sm-12 col-form-label">Estado</label>
                                {!! form::text('state', null, [
                                    'id' => 'state',
                                    'class' => 'form-control outlinenone',
                                    'placeholder' => 'Estado',
                                    'disabled' => 'disabled',
                                ]) !!}
                            </div>

                            <div class="col-sm-2 detail" style="display: none;">
                                <label for="city" class="col-sm-12 col-form-label">Ciudad</label>
                                {!! form::text('city', null, [
                                    'id' => 'city',
                                    'class' => 'form-control outlinenone',
                                    'placeholder' => 'Ciudad',
                                    'disabled' => 'disabled',
                                ]) !!}
                            </div>

                            <div class="col-sm-4 detail" style="display: none;">
                                <label for="address" class="col-sm-12 col-form-label">Dirección</label>
                                {!! form::text('address', null, [
                                    'id' => 'address',
                                    'class' => 'form-control outlinenone',
                                    'placeholder' => 'Dirección',
                                    'disabled' => 'disabled',
                                ]) !!}
                            </div>

                            <div class="col-sm-2 detail" style="display: none;">
                                <label for="postal_code" class="col-sm-12 col-form-label">Código Postal</label>
                                {!! form::text('postal_code', null, [
                                    'id' => 'postal_code',
                                    'class' => 'form-control outlinenone',
                                    'placeholder' => 'Código Postal',
                                    'disabled' => 'disabled',
                                ]) !!}
                            </div>

                            <div class="col-sm-2 detail" style="display: none;">
                                <label for="telephone" class="col-sm-12 col-form-label">Teléfono / Movíl</label>
                                {!! form::text('telephone', null, [
                                    'id' => 'telephone',
                                    'class' => 'form-control outlinenone',
                                    'placeholder' => 'No. Movíl',
                                    'disabled' => 'disabled',
                                ]) !!}
                            </div>
                        </div>

                        <div class="detail" style="display: none;">
                            <hr />
                            <h4 class="mt-0 m-b-30 header-title"><b>Información de Cobro</b></h4>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-2 detail" style="display: none;">
                                <label for="invoice_id" class="col-sm-12 col-form-label">No. Cobro</label>
                                {!! form::text('invoice_id', null, [
                                    'id' => 'invoice_id',
                                    'class' => 'form-control outlinenone',
                                    'placeholder' => 'No. Cobro',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>

                            <div class="col-sm-2 detail" style="display: none;">
                                <label for="fechpro" class="col-sm-12 col-form-label">Creado</label>
                                {!! form::text('fechpro', null, [
                                    'id' => 'fechpro',
                                    'class' => 'form-control text-center outlinenone',
                                    'placeholder' => 'Fecha Generado',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>

                            <div class="col-sm-3 detail" style="display: none;">
                                <label for="user_created" class="col-sm-12 col-form-label">Generado Por</label>
                                {!! form::text('user_created', null, [
                                    'id' => 'user_created',
                                    'class' => 'form-control outlinenone',
                                    'placeholder' => 'Generado Por',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>

                            <div class="col-sm-2 detail" style="display: none;">
                                <label for="type_sale" class="col-sm-12 col-form-label">Tipo Venta</label>
                                {!! form::text('type_sale', null, [
                                    'id' => 'type_sale',
                                    'class' => 'form-control outlinenone',
                                    'placeholder' => 'Método Pago',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>

                            <div class="col-sm-3 detail" style="display: none;">
                                <label for="payment_method" class="col-sm-12 col-form-label">Método Pago</label>
                                {!! form::text('payment_method', null, [
                                    'id' => 'payment_method',
                                    'class' => 'form-control outlinenone',
                                    'placeholder' => 'Método Pago',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>

                            <div class="col-sm-2 detail" style="display: none;">
                                <label for="modelterminal" class="col-sm-12 col-form-label">Modelo Equipo</label>
                                {!! form::text('modelterminal', null, [
                                    'id' => 'modelterminal',
                                    'class' => 'form-control outlinenone',
                                    'placeholder' => 'Método Pago',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>

                            <div class="col-sm-1 detail" style="display: none;">
                                <label for="currency_show" class="col-sm-12 col-form-label">Divisa</label>
                                {!! form::text('currency_show', null, [
                                    'id' => 'currency_show',
                                    'class' => 'form-control text-center outlinenone',
                                    'placeholder' => 'Divisa',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>

                            <div class="col-sm-2 detail" style="display: none;">
                                <label for="amount_show" class="col-sm-12 col-form-label">Monto Cobro</label>
                                {!! form::text('amount_show', null, [
                                    'id' => 'amount_show',
                                    'class' => 'form-control text-center outlinenone',
                                    'placeholder' => 'Generado Por',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>

                            <div class="col-sm-2 detail" style="display: none;">
                                <label for="dicom_show" class="col-sm-12 col-form-label">BCV</label>
                                {!! form::text('dicom_show', null, [
                                    'id' => 'dicom_show',
                                    'class' => 'form-control text-center outlinenone',
                                    'placeholder' => 'Tarifa Dicom',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>

                            <div class="col-sm-2 detail" style="display: none;">
                                <label for="total_show" class="col-sm-12 col-form-label">Monto Bs.</label>
                                {!! form::text('total_show', null, [
                                    'id' => 'total_show',
                                    'class' => 'form-control text-center outlinenone',
                                    'placeholder' => 'Total Facturado',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>

                            <div class="col-sm-1 detail" style="display: none;">
                                <label for="statusc" class="col-sm-12 col-form-label">Status</label>
                                {!! form::text('statusc', null, [
                                    'id' => 'statusc',
                                    'class' => 'form-control text-center outlinenone',
                                    'placeholder' => 'Status',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>

                            <div class="col-sm-2 invoiceitem" style="display: none;">
                                <label class="col-sm-12 col-form-label">No. Cuota<small>*</small></label>
                                {!! form::select('invoiceitem_id', [], null, ['id' => 'invoiceitem_id', 'class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="invoiceitems" style="display:none;">
                            <hr />
                            <center>
                                <h4 class="mt-0 m-b-30 header-title"><b>Información Detallada x Conciliar</b></h4>
                            </center>
                        </div>

                        <div class="invoiceitems" style="display:none;">
                            <div class="col-sm-12 p-2">
                                <table id="conciliate-detail" name="conciliate-detail"
                                    class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                <center>No. Cobro</center>
                                            </th>
                                            <th>
                                                <center>Límite Pago</center>
                                            </th>
                                            <th>
                                                <center>No. Item</center>
                                            </th>
                                            <th>
                                                <center>Descripción</center>
                                            </th>
                                            <th>
                                                <center>Divisa</center>
                                            </th>
                                            <th>
                                                <center>Monto Divisa</center>
                                            </th>
                                            <th>
                                                <center>BCV</center>
                                            </th>
                                            <th>
                                                <center>Monto Bs. x Conciliar</center>
                                            </th>
                                            <th>
                                                <center>Status</center>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                        
                            <div class="col-sm-6 p-2">
                                <table id="comision" name="comision"
                                    class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                <center>Comision Cobrada</center>
                                            </th>
                                            <th>
                                                <center>Comision Pendiente</center>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="col-sm-12">
                                                    {!! form::text('comi_a', null, [
                                                        'id' => 'comi_a',
                                                        'class' => 'form-control text-center money',
                                                        'placeholder' => '----',
                                                        'readonly' => 'readonly',
                                                    ]) !!}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-sm-12" >
                                                    {!! form::text('comi_b', null, [
                                                        'id' => 'comi_b',
                                                        'class' => 'form-control text-center money',
                                                        'placeholder' => '----',
                                                        'readonly' => 'readonly',
                                                    ]) !!}
                                                </div>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        <div class="col-sm-12 invoiceitems" align="center" style="display:none;">
                            <div class="form-group">
                                <label>Necesita más Campos?</label>
                                <center>
                                    <button class="btn btn-sm btn-default waves-effect waves-light" type="button"
                                        id="btnAdd" value="+" /><b>+</b></button>
                                    <button class="btn btn-sm btn-default waves-effect waves-light" type="button"
                                        id="btnDel" value="-" /><b>-</b></button>
                                </center>
                            </div>
                        </div>

                        <div id="input1" class="col-sm-12 clonedInput invoiceitems" style="display:none;">
                            <div class="row" id="item1">
                                <div class="col-sm-2">
                                    Date
                                    <div class="input-group">
                                        <div class="input-group-append"><span class="input-group-text"><i
                                                    class="i-Calendar"></i></span></div>
                                        <input id="date_fechpro[]" name="date_fechpro[]" type="text"
                                            class="form-control datepicker" placeholder="yyyy-mm-dd"
                                            data-toggle="datepicker" required>
                                    </div><!-- input-group -->
                                </div>

                                <div class="col-sm-2">
                                    Cuenta
                                    {!! form::select('acconcept[]', [], null, [
                                        'id' => 'acconcept[]',
                                        'class' => 'form-control acconcept',
                                        'placeholder' => 'Seleccione Cuenta Contable...',
                                        'required' => 'required',
                                    ]) !!}
                                </div>

                                <div class="col-sm-3">
                                    Referencia
                                    {!! form::text('refer[]', null, [
                                        'id' => 'refer[]',
                                        'class' => 'form-control ',
                                        'placeholder' => 'Ingrese Referencia',
                                        'required' => 'required',
                                    ]) !!}
                                </div>

                                <div class="col-sm-1">
                                    Moneda
                                    {!! form::select('currency[]', [], null, [
                                        'id' => 'currency[]',
                                        'class' => 'form-control currency',
                                        'required' => 'required',
                                    ]) !!}
                                </div>

                                <div class="col-sm-1">
                                    Monto USD
                                    {!! form::text('amount_currency[]', 0.0, [
                                        'id' => 'amount_currency[]',
                                        'class' => 'form-control amountc money',
                                        'onchange' => 'comprobar();',
                                        'placeholder' => 'Ingrese Monto Divisa',
                                    ]) !!}
                                </div>

                                <div class="col-sm-1">
                                    Monto Bs
                                    {!! form::text('amount[]', 0.0, [
                                        'id' => 'amount[]',
                                        'class' => 'form-control money',
                                        'onchange' => 'comprobar();',
                                        'placeholder' => 'Ingrese Monto Bs.',
                                        'required' => 'required',
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row invoiceitems" style="display:none;">
                            <hr />
                            <div class="col-sm-12 text-right">
                                <h5>
                                    <label for="total" class="col-sm-12 col-form-label">Total x Conciliar Bs.</label>
                                    <b>
                                        <div id="total" size="14"></div>
                                    </b>
                                </h5>
                            </div>
                        </div>

                        <div class="text-center invoiceitems" style="display:none;">
                            <button type="submit" onclick="checkCollection(event)" class="btn btn-sm btn-info"><i
                                    class="dripicons-user"></i> Conciliar</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- Content-->
@endsection
@include('sales::collections.show')
@section('page-js')
    <script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>

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
            },
        });

        var invoice_id = '{!! $_GET['invoice_id'] !!}';
        if (invoice_id) {
            $.get('/invoices/find?view={!! $_GET['view'] !!}&invoice_id=' + {!! (int) $_GET['invoice_id'] !!}, function(data) {
                if (data == '') {
                    $("#find").val('');
                    $(".detail").css('display', 'none');
                    $(".invoiceitems").css('display', 'none');
                } else {
                    comprobar();
                    $(".detail").css('display', 'block');
                    $('#collections-detail > tbody').empty();
                    $("#customer_id").val(data[0].customer_id);
                    $("#rif").val(data[0].rif);
                    $("#business_name").val(data[0].business_name);
                    $("#state").val(data[0].state);
                    $("#city").val(data[0].city);
                    $("#address").val(data[0].address);
                    $("#postal_code").val(data[0].postal_code);
                    $("#telephone").val(data[0].telephone);
                    $("#invoice_id").val(data[0].id);
                    $("#user_created").val(data[0].user_name);
                    $("#fechpro").val(data[0].fechpro);
                    $("#payment_method").val(data[0].tipnot);
                    $("#type_sale").val(data[0].type_sale);
                    $("#modelterminal").val(data[0].modelterminal);
                    $("#currency_show").val(data[0].currency_invoice);
                    $("#dicom_show").val(data[0].dicom);
                    $("#amount_show").val(data[0].amount_invoice);
                    $("#total_show").val(data[0].amount_total);
                    $("#statusc").val(data[0].status_invoice);

                    if (data[0].currency_id > 1) {
                        $('.amountc').removeAttr('readonly');
                        $('.amountc').attr('required', true);
                        $('.currency').empty();
                        $('.currency').append("<option value='" + data[0].currency_id + "'>" + data[0]
                            .currency_invoice + "</option>");
                        $('#dicom_invoiceitem').removeAttr('readonly');
                    } else {
                        $('.amountc').removeAttr('required');
                        $('.amountc').attr('readonly', true);
                        $('.currency').empty();
                        $('.currency').append("<option value='" + data[0].currency_id + "'>" + data[0]
                            .currency_invoice + "</option>");
                        $('#dicom_invoiceitem').attr('readonly', true);
                    }

                    $.get('/invoiceitems/' + data[0].id +
                        '?invoiceitem_id=<?php echo $_GET['invoiceitem_id']; ?>&view=<?php echo $_GET['view']; ?>',
                        function(res) {
                            if (res.length > 0) {
                                $(".invoiceitem").css('display', 'block');
                                $('#invoiceitem_id').empty()
                                $('#invoiceitem_id').append(
                                    "<option value=''>Seleccione Cuota / Item...</option>");

                                $.each(res, function(index, subInvoiceItemObj) {
                                    document.getElementById("invoiceitem_id").disabled = false;
                                    $('#invoiceitem_id').append("<option value='" + subInvoiceItemObj
                                        .id + "'>" + subInvoiceItemObj.concept + " " +
                                        subInvoiceItemObj.item + "-> " + subInvoiceItemObj
                                        .currency + " " + subInvoiceItemObj.amount + "</option>");
                                });
                            } else {
                                $(".invoiceitem").css('display', 'none');
                                $(".invoiceitems").css('display', 'block');
                                $('#conciliate-detail > tbody').empty();

                                var tbl = document.getElementById("conciliate-detail");
                                var tblBody = document.createElement("tbody");

                                var fila = document.createElement("tr");

                                var celda = document.createElement("td");
                                var textoCelda = document.createTextNode(data[0].id);
                                celda.appendChild(textoCelda);
                                fila.appendChild(celda);

                                var celda = document.createElement("td");
                                var textoCelda = document.createTextNode('---');
                                celda.appendChild(textoCelda);
                                fila.appendChild(celda);

                                var celda = document.createElement("td");
                                var textoCelda = document.createTextNode('---');
                                celda.appendChild(textoCelda);
                                fila.appendChild(celda);

                                var celda = document.createElement("td");
                                var textoCelda = document.createTextNode(data[0].modelterminal);
                                celda.appendChild(textoCelda);
                                fila.appendChild(celda);

                                var celda = document.createElement("td");
                                var textoCelda = document.createTextNode(data[0].currency_invoice);
                                celda.appendChild(textoCelda);
                                fila.appendChild(celda);

                                var celda = document.createElement("td");
                                var textoCelda = document.createElement("INPUT");
                                textoCelda.setAttribute("id", "amountc_invoiceitem");
                                textoCelda.setAttribute("name", "amountc_invoiceitem");
                                textoCelda.setAttribute("type", "text");
                                textoCelda.setAttribute("readonly", "readonly");
                                textoCelda.setAttribute("class", "form-control outlinenone text-center money");
                                textoCelda.value = data[0].amount_invoice;
                                celda.appendChild(textoCelda);
                                fila.appendChild(celda);


                                var celda = document.createElement("td");
                                var textoCelda = document.createElement("INPUT");
                                textoCelda.setAttribute("id", "dicom_invoiceitem");
                                textoCelda.setAttribute("name", "dicom_invoiceitem");
                                textoCelda.setAttribute("type", "text");
                                textoCelda.setAttribute("required", "required");
                                if (data[0].currency_invoice == 'Bs.') {
                                    textoCelda.setAttribute("readonly", "readonly");
                                }
                                textoCelda.setAttribute("onchange", "amountInvoice(this);");
                                textoCelda.setAttribute("class", "form-control text-center money");
                                textoCelda.value = data[0].dicom;
                                celda.appendChild(textoCelda);
                                fila.appendChild(celda);

                                var celda = document.createElement("td");
                                var textoCelda = document.createElement("INPUT");
                                textoCelda.setAttribute("id", "amount_invoiceitem");
                                textoCelda.setAttribute("name", "amount_invoiceitem");
                                textoCelda.setAttribute("type", "text");
                                textoCelda.setAttribute("readonly", "readonly");
                                textoCelda.setAttribute("class", "form-control outlinenone text-center money");
                                textoCelda.value = data[0].amount_total;
                                celda.appendChild(textoCelda);
                                fila.appendChild(celda);

                                var celda = document.createElement("td");
                                var textoCelda = document.createElement("INPUT");
                                textoCelda.setAttribute("id", "status_invoiceitem");
                                textoCelda.setAttribute("name", "status_invoiceitem");
                                textoCelda.setAttribute("type", "text");
                                textoCelda.setAttribute("readonly", "readonly");
                                textoCelda.setAttribute("class", "form-control outlinenone text-center");
                                textoCelda.value = data[0].status_invoice;
                                celda.appendChild(textoCelda);
                                fila.appendChild(celda);

                                tblBody.appendChild(fila);
                                tbl.appendChild(tblBody);
                                tbl.setAttribute("border", "2");
                            }
                        });
                }
            });
        } else {
            $(".detail").css('display', 'none');
            $(".invoiceitems").css('display', 'none');
        }
        /****************************************************************************/
        $.get('/acconcepts/select?filter=collection', function(data) {
            $.each(data, function(index, subAcconceptObj) {
                $('.acconcept').append("<option value='" + subAcconceptObj.id + "'>" + subAcconceptObj
                    .description + "</option>");
            });
        });
        /****************************************************************************/
        $('.find').on('click', function(e) {
            var find = document.getElementById("find").value;
            var count = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
            do {
                if (count > 1) {
                    $('#input' + count).remove(); // remove the last element
                    count = count - 1;
                }
            } while (count > 1);

            if (find != '') {
                $.get('/invoices/find?view={!! $_GET['view'] !!}&invoice_id=' + find, function(data) {
                    if (data == '') {
                        $("#find").val('');
                        $(".detail").css('display', 'none');
                        $(".invoiceitems").css('display', 'none');
                        $(".invoiceitem").css('display', 'none');
                        swal('Error en la consulta', 'Por favor verifique No. Cobro e intenté de nuevo',
                            'warning');
                    } else {
                        $(".detail").css('display', 'block');
                        $(".invoiceitems").css('display', 'none');
                        $('#conciliate-detail > tbody').empty();
                        comprobar();
                        $("#customer_id").val(data[0].customer_id);
                        $("#rif").val(data[0].rif);
                        $("#business_name").val(data[0].business_name);
                        $("#state").val(data[0].state);
                        $("#city").val(data[0].city);
                        $("#address").val(data[0].address);
                        $("#postal_code").val(data[0].postal_code);
                        $("#telephone").val(data[0].telephone);
                        $("#invoice_id").val(data[0].id);
                        $("#user_created").val(data[0].user_name);
                        $("#fechpro").val(data[0].fechpro);
                        $("#payment_method").val(data[0].tipnot);
                        $("#type_sale").val(data[0].type_sale);
                        $("#modelterminal").val(data[0].modelterminal);
                        $("#currency_show").val(data[0].currency_invoice);
                        $("#dicom_show").val(data[0].dicom);
                        $("#amount_show").val(data[0].amount_invoice);
                        $("#total_show").val(data[0].amount_total);
                        $('#statusc').val(data[0].status_invoice);
                        if (data[0].currency_id > 1) {
                            $('.amountc').removeAttr('readonly');
                            $('.amountc').attr('required', true);
                            $('.currency').empty();
                            $('.currency').append("<option value='" + data[0].currency_id + "'>" + data[0]
                                .currency_invoice + "</option>");
                            $('#dicom_invoiceitem').removeAttr('readonly');
                        } else {
                            $('.amountc').removeAttr('required');
                            $('.amountc').attr('readonly', true);
                            $('.currency').empty();
                            $('.currency').append("<option value='" + data[0].currency_id + "'>" + data[0]
                                .currency_invoice + "</option>");
                            $('#dicom_invoiceitem').attr('readonly', true);
                        }

                        $.get('/invoiceitems/' + data[0].id +
                            '?invoiceitem_id=<?php echo $_GET['invoiceitem_id']; ?>&view=<?php echo $_GET['view']; ?>',
                            function(res) {
                                if (res.length > 0) {
                                    $(".invoiceitem").css('display', 'block');
                                    $('#invoiceitem_id').empty();
                                    $('#invoiceitem_id').append(
                                        "<option value=''>Seleccione Cuota / Item...</option>");

                                    $.each(res, function(index, subInvoiceItemObj) {
                                        document.getElementById("invoiceitem_id").disabled =
                                            false;
                                        $('#invoiceitem_id').append("<option value='" +
                                            subInvoiceItemObj.id + "'>" + subInvoiceItemObj
                                            .concept + " " + subInvoiceItemObj.item +
                                            "-> " + subInvoiceItemObj.currency + " " +
                                            subInvoiceItemObj.amount + "</option>");
                                    });
                                } else {
                                    $(".invoiceitem").css('display', 'none');
                                    $(".invoiceitems").css('display', 'block');
                                    $('#conciliate-detail > tbody').empty();
                                    var tbl = document.getElementById("conciliate-detail");
                                    var tblBody = document.createElement("tbody");

                                    var fila = document.createElement("tr");

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(data[0].id);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode('---');
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode('---');
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(data[0].modelterminal);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(data[0].currency_invoice);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createElement("INPUT");
                                    textoCelda.setAttribute("id", "amountc_invoiceitem");
                                    textoCelda.setAttribute("name", "amountc_invoiceitem");
                                    textoCelda.setAttribute("type", "text");
                                    textoCelda.setAttribute("readonly", "readonly");
                                    textoCelda.setAttribute("class",
                                        "form-control outlinenone text-center money");
                                    textoCelda.value = data[0].amount_invoice;
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createElement("INPUT");
                                    textoCelda.setAttribute("id", "dicom_invoiceitem");
                                    textoCelda.setAttribute("name", "dicom_invoiceitem");
                                    textoCelda.setAttribute("type", "text");
                                    textoCelda.setAttribute("required", "required");
                                    textoCelda.setAttribute("readonly", "readonly");
                                    textoCelda.setAttribute("onchange", "amountInvoice(this);");
                                    textoCelda.setAttribute("class", "form-control text-center money");
                                    textoCelda.value = data[0].dicom;
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createElement("INPUT");
                                    textoCelda.setAttribute("id", "amount_invoiceitem");
                                    textoCelda.setAttribute("name", "amount_invoiceitem");
                                    textoCelda.setAttribute("type", "text");
                                    textoCelda.setAttribute("readonly", "readonly");
                                    textoCelda.setAttribute("class",
                                        "form-control outlinenone text-center money");
                                    textoCelda.value = data[0].amount_total;
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createElement("INPUT");
                                    textoCelda.setAttribute("id", "status_invoiceitem");
                                    textoCelda.setAttribute("name", "status_invoiceitem");
                                    textoCelda.setAttribute("type", "text");
                                    textoCelda.setAttribute("readonly", "readonly");
                                    textoCelda.setAttribute("class", "form-control text-center");
                                    textoCelda.value = data[0].status_invoice;
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    tblBody.appendChild(fila);
                                    tbl.appendChild(tblBody);
                                    tbl.setAttribute("border", "2");
                                }
                            });
                    }
                });
            } else {
                $("#find").val('');
                $(".detail").css('display', 'none');
                $(".invoiceitems").css('display', 'none');
                $(".invoiceitem").css('display', 'none');
                swal('Error en la consulta', 'Por favor verifique No. Cobro e intenté de nuevo', 'warning');
            }
        });
        /****************************************************************************/
        $('.invoiceitem').on('change', function(e) {
            var invoiceitem_id = document.getElementById("invoiceitem_id").value;
            $.get('/invoiceitems/find?invoiceitem_id=' + invoiceitem_id, function(data) {
                if (data) {
                    $(".invoiceitems").css('display', 'block');
                    $('#conciliate-detail > tbody').empty();
                    var tbl = document.getElementById("conciliate-detail");
                    var tblBody = document.createElement("tbody");

                    var fila = document.createElement("tr");

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(data.invoice_id);
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(data.date_expire);
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(data.id);
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    if (data.item > 0) {
                        var refere = data.concept + ' - ' + data.item + ' Cuota';
                    } else {
                        var refere = data.concept;
                    }
                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(refere);
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(data.currency);
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createElement("INPUT");
                    textoCelda.setAttribute("id", "amountc_invoiceitem");
                    textoCelda.setAttribute("name", "amountc_invoiceitem");
                    textoCelda.setAttribute("type", "text");
                    textoCelda.setAttribute("readonly", "readonly");
                    textoCelda.setAttribute("class", "form-control outlinenone text-center money");
                    textoCelda.value = data.amount;
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    $.get('/currencyvalues/getLast', function(res) {
                        if (res) {
                            var dicom = res.value;
                            dicom = dicom.replace(",", "");

                            var celda = document.createElement("td");
                            var textoCelda = document.createElement("INPUT");
                            textoCelda.setAttribute("id", "dicom_invoiceitem");
                            textoCelda.setAttribute("name", "dicom_invoiceitem");
                            textoCelda.setAttribute("type", "text");
                            textoCelda.setAttribute("required", "required");
                            textoCelda.setAttribute("onchange", "amountInvoice(this);");
                            textoCelda.setAttribute("class", "form-control text-center money");
                            textoCelda.value = dicom;
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            var celda = document.createElement("td");
                            var textoCelda = document.createElement("INPUT");
                            textoCelda.setAttribute("id", "amount_invoiceitem");
                            textoCelda.setAttribute("name", "amount_invoiceitem");
                            textoCelda.setAttribute("type", "text");
                            textoCelda.setAttribute("readonly", "readonly");
                            textoCelda.setAttribute("class",
                                "form-control outlinenone text-center");
                            textoCelda.value = fNumber.go(parseFloat(parseFloat(dicom) * parseFloat(
                                data.amount)).toFixed(2));
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);
                        } else {
                            var celda = document.createElement("td");
                            var textoCelda = document.createElement("INPUT");
                            textoCelda.setAttribute("id", "dicom_invoiceitem");
                            textoCelda.setAttribute("name", "dicom_invoiceitem");
                            textoCelda.setAttribute("type", "text");
                            textoCelda.setAttribute("required", "required");
                            textoCelda.setAttribute("readonly", "readonly");
                            textoCelda.setAttribute("class", "form-control text-center money");
                            textoCelda.value = fNumber.go(0);
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            var celda = document.createElement("td");
                            var textoCelda = document.createElement("INPUT");
                            textoCelda.setAttribute("id", "amount_invoiceitem");
                            textoCelda.setAttribute("name", "amount_invoiceitem");
                            textoCelda.setAttribute("type", "text");
                            textoCelda.setAttribute("readonly", "readonly");
                            textoCelda.setAttribute("class",
                                "form-control outlinenone text-center");
                            textoCelda.value = fNumber.go(0);
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);
                        }

                        var celda = document.createElement("td");
                        var textoCelda = document.createElement("INPUT");
                        textoCelda.setAttribute("id", "status_invoiceitem");
                        textoCelda.setAttribute("name", "status_invoiceitem");
                        textoCelda.setAttribute("type", "text");
                        textoCelda.setAttribute("readonly", "readonly");
                        textoCelda.setAttribute("class", "form-control outlinenone text-center");
                        textoCelda.value = data.status;
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);
                    });

                    tblBody.appendChild(fila);
                    tbl.appendChild(tblBody);
                    tbl.setAttribute("border", "2");
                } else {
                    $(".invoiceitems").css('display', 'none');
                    $('#conciliate-detail > tbody').empty();
                }
            });
        });
        /****************************************************************************/
        function amountInvoice(e) {
            var dicom_invoiceitem = e.value;
            dicom_invoiceitem = dicom_invoiceitem.replace(",", "");
            dicom_invoiceitem = dicom_invoiceitem.replace(",", "");
            var amountc_invoiceitem = document.getElementById("amountc_invoiceitem").value;
            amountc_invoiceitem = amountc_invoiceitem.replace(",", "");
            amountc_invoiceitem = amountc_invoiceitem.replace(",", "");

            var amount_invoiceitem = fNumber.go(parseFloat(dicom_invoiceitem) * parseFloat(amountc_invoiceitem));
            amount_invoiceitem = amount_invoiceitem.replace(",", "");
            amount_invoiceitem = amount_invoiceitem.replace(",", "");
            document.getElementById("amount_invoiceitem").value = fNumber.go(parseFloat(amount_invoiceitem).toFixed(2));
        }
        /****************************************************************************/
        $('#btnDel').attr('disabled', 'disabled');
        $('#btnAdd').click(function() {
            comprobar();
            var num = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
            var newNum = new Number(num + 1); // the numeric ID of the new input field being added
            // create the new element via clone(), and manipulate it's ID using newNum value
            var newElem = $('#input' + num).clone().attr('id', 'input' + newNum);
            // manipulate the name/id values of the input inside the new element
            // Añadir caja de texto.
            newElem.children(':last').attr('id', 'item' + newNum).attr('name', 'item' + newNum).find('input').val(
                "");
            // insert the new element after the last "duplicatable" input field
            $('#input' + num).after(newElem);
            var i = 0;
            flatpickr('.datepicker', {
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
                },
            });
            // enable the "remove" button
            $('#btnDel').attr('disabled', false);
            // business rule: you can only add 10 names
            if (newNum == 100)
                $('#btnAdd').attr('disabled', 'disabled');
        });
        /****************************************************************************/
        $('#btnDel').click(function() {
            comprobar();
            var num = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
            $('#input' + num).remove(); // remove the last element

            // enable the "add" button
            $('#btnAdd').attr('disabled', false);

            // if only one element remains, disable the "remove" button
            if (num - 1 == 1)
                $('#btnDel').attr('disabled', 'disabled');
        });
        /****************************************************************************/
        /* Evento para cuando el usuario libera la tecla escrita dentro del input */
        $('.blank').blur(function() {
            /* Obtengo el valor contenido dentro del input */
            var value = $(this).val();

            /* Elimino todos los espacios en blanco que tenga la cadena delante y detrás */
            var value_without_space = $.trim(value);

            /* Cambio el valor contenido por el valor sin espacios */
            $(this).val(value_without_space);
        });
        /****************************************************************************/
        $('.money').mask(' 000,000,000,000,000.00', {
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
        /****************************************************************************/
        function comprobar() {
            var chks = document.getElementsByName('amount[]');
            var total = 0;
            for (var i = 0; i < chks.length; i++) {
                var amount_value = chks[i].value;
                amount_value = amount_value.replace(",", "");
                amount_value = amount_value.replace(",", "");
                total = (parseFloat(amount_value) + parseFloat(total));
            }
            if (isNaN(total)) {
                total = 0;
            }
            document.getElementById("total").innerHTML = fNumber.go(total);
        }
        /****************************************************************************/
        function checkCollection(event) {
            var amount_collection = document.getElementById("total").innerHTML;
            amount_collection = amount_collection.replace(",", "");
            amount_collection = amount_collection.replace(",", "");
            var amount_invoice = document.getElementById("amount_invoiceitem").value;
            amount_invoice = amount_invoice.replace(",", "");
            amount_invoice = amount_invoice.replace(",", "");
            if (parseFloat(amount_invoice) == parseFloat(amount_collection)) {
                return true;
            }
            swal('Error al Registrar', 'Por favor verifique los Montos A Conciliar e Intente Nuevamente', 'warning');
            event.preventDefault();
            return false;
        }
    </script>
@endsection
