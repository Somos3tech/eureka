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
                    {!! Form::open(['id' => 'form', 'route' => 'serviceSupport.store', 'method' => 'POST']) !!}

                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-sm-2">
                            <label class="col-sm-12">&nbsp;</label>
                            {!! form::text('find', null, [
                                'id' => 'find',
                                'class' => 'form-control text-center rif clear',
                                'placeholder' => 'Ingrese No. Contrato',
                            ]) !!}
                        </div>

                        <div class="col-sm-1">
                            <label class="col-sm-12">&nbsp;</label>
                            <button type="button" name="find"
                                class="btn btn-sm btn-fill btn-dark find">Consultar</button>
                        </div>

                        <div class="col-sm-1 contract" style="display:none;">
                            <label for="contract_id" class="col-sm-12">Cont.</label>
                            {!! form::hidden('id', null, ['id' => 'id']) !!}
                            {!! form::hidden('created_at_support', null, ['id' => 'created_at_support']) !!}
                            {!! form::hidden('posted_at_support', null, ['id' => 'posted_at_support']) !!}
                            {!! form::hidden('observation_support', null, ['id' => 'observation_support']) !!}
                            {!! form::hidden('company_id_support', null, ['id' => 'company_id_support']) !!}
                            {!! form::hidden('type_dcustomer_support', null, ['id' => 'type_dcustomer_support']) !!}
                            {!! form::hidden('dcustomer_id_support', null, ['id' => 'dcustomer_id_support']) !!}
                            {!! form::hidden('modelterminal_id_support', null, ['id' => 'modelterminal_id_support']) !!}
                            {!! form::hidden('terminal_id_support', null, ['id' => 'terminal_id_support']) !!}
                            {!! form::hidden('valid_simcard_support', null, ['id' => 'valid_simcard_support']) !!}
                            {!! form::hidden('operator_id_support', null, ['id' => 'operator_id_support']) !!}
                            {!! form::hidden('simcard_id_support', null, ['id' => 'simcard_id_support']) !!}
                            {!! form::hidden('status_support', null, ['id' => 'status_support']) !!}
                            {!! form::hidden('term_id_support', null, ['id' => 'term_id_support']) !!}
                            {!! form::hidden('user_created_id_support', null, ['id' => 'user_created_id_support']) !!}
                            {!! form::hidden('consultant_id_support', null, ['id' => 'consultant_id_support']) !!}
                            {!! form::hidden('delivery_date_support', null, ['id' => 'delivery_date_support']) !!}
                            {!! form::hidden('type_condition_support', null, ['id' => 'type_condition_support']) !!}
                            {!! form::text('contract_id', null, [
                                'id' => 'contract_id',
                                'class' => 'form-control',
                                'placeholder' => 'Ingresar No. Contrato',
                                'readonly' => 'readonly',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 contract" style="display:none;">
                            <label for="customer_id" class="col-sm-12">Código</label>
                            {!! form::text('customer_id', null, [
                                'id' => 'customer_id',
                                'class' => 'form-control',
                                'placeholder' => 'Ingresar Código',
                                'readonly' => 'readonly',
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
                            <hr><br>
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
                                            <center>Almacén</center>
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
                                            <center>Operador</center>
                                        </th>
                                        <th>
                                            <center>Serial</center>
                                        </th>
                                        <th>
                                            <center>Condición Comercial</center>
                                        </th>
                                        <th>
                                            <center>Asesor Venta</center>
                                        </th>
                                        <th>
                                            <center>Aliado</center>
                                        </th>
                                        <th>
                                            <center>Observaci&oacute;n</center>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                            <hr>
                        </div>

                        <div class="col-sm-2 contract" style="display:none;">
                            <label for="type_service" class="col-sm-12">Tipo Cambio*</label>
                            {!! form::select('type_service', [], null, [
                                'id' => 'type_service',
                                'class' => 'form-control',
                                'placeholder' => 'Seleccione Cambio a Realizar...',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 support created" style="display:none;">
                            <div class="col-sm-12">
                                <label for="created_at" class="col-sm-12">Creado<small>*</small></label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                    <input id="created_at" name="created_at" type="text"
                                        class="form-control created_at datepicker input" placeholder="yyyy-mm-dd"
                                        data-toggle="datepicker" readonly>
                                </div><!-- input-group -->
                            </div>
                        </div>

                        <div class="col-sm-2 support posted" style="display:none;">
                            <div class="col-sm-12">
                                <label for="posted_at" class="col-sm-12">Fecha Entrega<small>*</small></label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="i i-calendar"></i></span>
                                    </div>
                                    <input id="posted_at" name="posted_at" type="text"
                                        class="form-control posted_at datepicker input" placeholder="yyyy-mm-dd"
                                        data-toggle="datepicker" readonly>
                                </div><!-- input-group -->
                            </div>
                        </div>

                        <div class="col-sm-2 support company" style="display:none;">
                            <label for="company_id" class="col-sm-12">Almacén*</label>
                            {!! form::select('company_id', [], null, [
                                'id' => 'company_id',
                                'class' => 'form-control select2 company_id input',
                            ]) !!}
                        </div>

                        <div class="col-sm-3 support term" style="display:none;">
                            <label for="term_id" class="col-sm-12">Condición Comercial*</label>
                            {!! form::select('term_id', ['' => 'Seleccione Condición Comercial...'], null, [
                                'id' => 'term_id',
                                'class' => 'form-control select2 term_id input',
                            ]) !!}
                        </div>

                        <div class="col-sm-10 support affiliation" style="display:none;">
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="type_dcustomer" class="col-sm-12">Tipo Afiliación*</label>
                                    {!! form::select('type_dcustomer', [], null, [
                                        'id' => 'type_dcustomer',
                                        'class' => 'form-control select2 type_dcustomer input',
                                    ]) !!}
                                </div>

                                <div class="col-sm-3 support dcustomer" style="display:none;">
                                    <label for="dcustomer_id" class="col-sm-12">No. Afiliación Bancaria*</label>
                                    {!! form::select('dcustomer_id', ['' => 'Seleccione No. Afiliado'], null, [
                                        'id' => 'dcustomer_id',
                                        'class' => 'form-control select2 dcustomer dcustomer_id input',
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-2 support modelterminal" style="display:none;">
                            <label for="modelterminal_id" class="col-sm-12">Modelo Punto Venta*</label>
                            {!! form::select('modelterminal_id', ['' => 'Seleccione Modelo Punto de Venta...'], null, [
                                'id' => 'modelterminal_id',
                                'class' => 'form-control select2 modelterminal_id input',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 support operator" style="display:none;">
                            <center>
                                <label class="col-sm-12">Simcard No Incluida</label>
                                <label class="col-sm-12"><input type="checkbox" id="simcard_checkbox"
                                        name="simcard_checkbox" class="checkbox simcard_checkbox input"
                                        onclick="checkinput();"></label>
                            </center>
                        </div>

                        <div class="col-sm-3 support operator" style="display:none;">
                            <label for="operator_id" class="col-sm-12">Operador*</label>
                            {!! form::select('operator_id', ['' => 'Seleccione Operador...'], null, [
                                'id' => 'operator_id',
                                'class' => 'form-control select2 operator_id input',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 support numberpos" style="display:none;">
                            <label for="user_id" class="col-sm-12">No. Terminal*</label>
                            {!! form::text('nropos', null, ['id' => 'nropos', 'class' => 'form-control numbert nropos input']) !!}
                        </div>

                        <div class="col-sm-8 support observachange" style="display:none;">
                            <label for="user_id" class="col-sm-12">Observacion</label>
                            {!! form::text('observation', null, ['id' => 'observation', 'class' => 'form-control observation input']) !!}
                        </div>

                        <div class="col-sm-3 support sale_user" style="display:none;">
                            <label for="user_id" class="col-sm-12">Asesor / Asistente*</label>
                            {!! form::select('user_id', ['0' => 'Seleccione Asesor/Asistente Venta...'], null, [
                                'id' => 'user_id',
                                'class' => 'form-control select2 user_id input',
                            ]) !!}
                        </div>

                        <div class="col-sm-3 support sale_user" style="display:none;">
                            <label for="consultant_id" class="col-sm-12">Aliado Asociado*</label>
                            {!! form::select('consultant_id', ['' => 'Seleccione Aliado Asociado...'], null, [
                                'id' => 'consultant_id',
                                'class' => 'form-control select2 consultant_id input',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 support reactive_date" style="display:none;">
                            <div class="col-sm-12">
                                <label for="reactive_date" class="col-sm-12">Fecha Activación<small>*</small></label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="i i-calendar"></i></span>
                                    </div>
                                    <input id="reactive_date" name="reactive_date" type="text"
                                        class="form-control reactive_date datepicker input" placeholder="yyyy-mm-dd"
                                        data-toggle="datepicker" readonly>
                                </div><!-- input-group -->
                            </div>
                        </div>

                        <div class="col-sm-3 support terminal simcard" style="display:none;">
                            <label for="company_change_id" class="col-sm-12">Almacén*</label>
                            {!! form::select('company_change_id', ['' => 'Seleccione Almacén...'], null, [
                                'id' => 'company_change_id',
                                'class' => 'form-control search_terminal search_simcard company_change_id input',
                            ]) !!}
                        </div>

                        <div class="col-sm-3 support terminal" style="display:none;">
                            <label for="modelTerminal_change_id" class="col-sm-12">Modelo*</label>
                            {!! form::select('modelTerminal_change_id', ['' => 'Seleccione Modelo Terminal...'], null, [
                                'id' => 'modelTerminal_change_id',
                                'class' => 'form-control search_terminal modelTerminal_change_id input',
                            ]) !!}
                        </div>

                        <div class="col-sm-4 support terminal" style="display:none;">
                            <label for="terminal_change_id" class="col-sm-12">Serial Terminal*</label>
                            {!! form::select('terminal_change_id', ['' => 'Seleccione Serial Terminal...'], null, [
                                'id' => 'terminal_change_id',
                                'class' => 'form-control device terminal_change_id input',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 support simcard" style="display:none;">
                            <label for="operator_change_id" class="col-sm-12">Operador*</label>
                            {!! form::select('operator_change_id', ['' => 'Seleccione Operador...'], null, [
                                'id' => 'operator_change_id',
                                'class' => 'form-control search_simcard operator_change_id input',
                            ]) !!}
                        </div>

                        <div class="col-sm-5 support simcard" style="display:none;">
                            <label for="simcard_change_id" class="col-sm-12">Serial Simcard*</label>
                            {!! form::select('simcard_change_id', ['' => 'Seleccione Serial Simcard...'], null, [
                                'id' => 'simcard_change_id',
                                'class' => 'form-control device simcard_change_id input',
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group contract" style="display:none;">
                        <hr>
                        <div class="col-sm-12">
                            <center><button type="submit" class='btn btn-sm btn-info'
                                    name="Registrar">Actualizar</button>
                            </center>
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
    <script src="/assets/js/select2.min.js"></script>
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

            $('.device').select2({});
        });
        /****************************************************************************/
        $('.find').on('click', function(e) {
            var find = document.getElementById("find").value;
            if (find != '') {
                $.get('/contracts/findSupport?contract_id=' + find, function(data) {
                    $(".support").attr("style", "display:none");
                    if (data) {
                        $(".contract").attr("style", "display:block");
                        $("#id").val((data.contract_id));
                        $("#contract_id").val((data.contract_id));
                        $("#customer_id").val((data.customer_id));
                        $("#rif").val(data.rif);
                        $("#business_name").val(data.business_name);
                        $("#created_at_support").val(data.created);
                        $("#company_id_support").val(data.company_id);
                        $("#dcustomer_id_support").val(data.dcustomer_id);
                        $("#dcustomer_multiple_support").val(data.dcustomer_multiple);
                        $("#modelterminal_id_support").val(data.modelterminal_id);
                        $("#operator_id_support").val(data.operator_id);
                        $("#status_support").val(data.status_contract);
                        $("#term_id_support").val(data.term_id);
                        $("#user_created_id_support").val(data.user_created_id);
                        $("#consultant_id_support").val(data.consultant_id);
                        $("#delivery_date_support").val(data.delivery_date);
                        $("#terminal_id_support").val(data.terminal_id);
                        $("#valid_simcard_support").val(data.valid_simcard);
                        $("#simcard_id_support").val(data.simcard_id);
                        $("#posted_at_support").val(data.posted);
                        $("#observation_support").val(data.observation);

                        if (document.getElementById("type_dcustomer_support").value == 'commerce') {
                            document.getElementById("type_condition_support").value = 'Fijo';
                        }

                        if (document.getElementById("type_dcustomer_support").value == 'nodom') {
                            document.getElementById("type_condition_support").value = 'Fijo';
                        }

                        if (document.getElementById("type_dcustomer_support").value == 'multicommerce') {
                            document.getElementById("type_condition_support").value = 'Rango';
                        }

                        $('#type_service').empty();
                        $('#type_service').append(
                            "<option value=''>Seleccione Cambio a Realizar...</option>");

                        if ((document.getElementById("status_support").value == 'Activo') || (document
                                .getElementById("status_support").value == 'Pendiente') || (document
                                .getElementById("status_support").value == 'Suspendido')) {
                            $('#type_service').append("<option value='Created'>Fecha Generado</option>");
                            $('#type_service').append("<option value='Company'>Almacén</option>");

                            $('#type_service').append(
                                "<option value='Affiliation'>No. Afiliación - Modo Negocio</option>");
                            $('#type_service').append("<option value='Term'>Condición Comercial</option>");

                            if (document.getElementById("terminal_id_support").value != '') {
                                $('#type_service').append(
                                    "<option value='TerminalChange'>Cambio Terminal</option>");
                            } else {
                                $('#type_service').append(
                                    "<option value='ModelTerminal'>Modelo Terminal</option>");
                            }

                            if (document.getElementById("simcard_id_support").value != '') {
                                $('#type_service').append(
                                    "<option value='SimcardChange'>Cambio Simcard</option>");
                            } else {
                                $('#type_service').append("<option value='Operator'>Operador</option>");
                            }
                            $('#type_service').append("<option value='Nropos'>No. Terminal</option>");
                            $('#type_service').append("<option value='ObservationChange'>Observacion contrato</option>");
                            $('#type_service').append(
                                "<option value='User'>Vendedor - Aliado Comercial</option>");
                            $('#type_service').append("<option value='PostedTwo'>Fecha Entrega</option>");

                            if (document.getElementById("status_support").value == 'Activo') {
                                $('#type_service').append(
                                    "<option value='Cancel'>Cancelar Servicio</option>");
                            }
                            if (document.getElementById("status_support").value == 'Pendiente') {
                            $('#type_service').append("<option value='Destroy'>Anular Servicio</option>");
                            $('#type_service').append("<option value='Delete'>Eliminar Servicio</option>");
                            }
                        } else {
                            if (document.getElementById("status_support").value == 'Cancelado') {
                                if ((document.getElementById("terminal_id_support").value != '') || (
                                        document.getElementById("simcard_id_support").value != '')) {
                                    $('#type_service').append(
                                        "<option value='Restore'>Liberar Equipos</option>");
                                }

                                if ((document.getElementById("terminal_id_support").value != '')
                                    // && (document.getElementById("simcard_id_support").value != '')
                                ) {
                                    $('#type_service').append(
                                        "<option value='Reactive'>Reactivar Contrato</option>");
                                }
                            }
                        }
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
                        div.innerHTML = data.status;
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
                        var textoCelda = document.createTextNode(data.company);
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
                        var textoCelda = document.createTextNode(data.operator);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data.simcard);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data.term);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data.user);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data.consultant);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data.observation);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        tblBody.appendChild(fila);
                        tbl.appendChild(tblBody);
                        tbl.setAttribute("border", "2");
                    } else {
                        $(".contract").attr("style", "display:none");
                        $('#contracts-detail > tbody').empty();
                        $("#contract_id").val('');
                        $("#customer_id").val('');
                        $("#rif").val('');
                        $("#business_name").val('');
                        swal('', 'No se puede realizar Soporte a este Contrato ya que se encuentra Activo o Cancelado',
                            'info');
                    }
                });
            } else {
                $(".contract").attr("style", "display:none");
                $('#contracts-detail > tbody').empty();
                $("#contract_id").val('');
                $("#customer_id").val('');
                $("#rif").val('');
                $("#business_name").val('');
                swal('', 'Por favor Ingresar No.contrato', 'warning');
            }
        });
        /****************************************************************************/
        $('#type_service').on('change', function(e) {
            var type_service = e.target.value;
            $(".support").attr("style", "display:none");
            $('.input').removeAttr('required');
            $('.input').attr('disabled', 'disabled');

            switch (type_service) {
                case 'Created':
                    $(".created").attr("style", "display:block");
                    $('.created_at').removeAttr('disabled');
                    $('.created_at').attr('required', true);
                    var created = document.getElementById("created_at_support").value;
                    document.getElementById("created_at").value = created;
                    break;

                case 'Reactive':
                    $(".reactive_date").attr("style", "display:block");
                    $('.reactive_date').removeAttr('disabled');
                    $('.reactive_date').attr('required', true);
                    break;

                case 'Nropos':
                    $(".numberpos").attr("style", "display:block");
                    $('.nropos').removeAttr('disabled');
                    $('.nropos').attr('required', true);
                    break;

                case 'ObservationChange':
                    $(".observachange").attr("style", "display:block");
                    $('.observation').removeAttr('disabled');
                    $('.observation').attr('required', true);
                    var observation_data = document.getElementById("observation_support").value;
                    document.getElementById("observation").value = observation_data;
                    break;

                case 'PostedTwo':
                    $(".posted").attr("style", "display:block");
                    $('.posted_at').removeAttr('disabled');
                    $('.posted_at').attr('required', true);
                    var posted = document.getElementById("posted_at_support").value;
                    document.getElementById("posted_at").value = posted;
                    break;

                case 'Company':
                    $(".company").attr("style", "display:block");
                    $('.company_id').removeAttr('disabled');
                    $('.company_id').attr('required', true);
                    $.get('/companies/select/zone-valid?slug=sales.consultant&wholesaler=0', function(data) {
                        $('.company_id').empty();
                        $('.company_id').append("<option value=''>Seleccione Almacén Venta...</option>");
                        $.each(data, function(index, subCompanyObj) {
                            $('.company_id').append("<option value='" + subCompanyObj.id + "'>" +
                                subCompanyObj.description + "</option>");
                        });
                        $(".company_id option[value=" + document.getElementById("company_id_support")
                            .value + "]").attr("selected", true);
                    });
                    break;

                case 'Operator':
                    $(".operator").attr("style", "display:block");
                    $('.simcard_checkbox').removeAttr('disabled');
                    if (document.getElementById("valid_simcard_support").value == 0) {
                        $("#simcard_checkbox").prop("checked", 0);
                        $('.operator_id').removeAttr('disabled');
                        $('.operator_id').attr('required', true);
                    } else {
                        $("simcard_checkbox").prop("checked", 1);
                        $('.operator_id').attr('disabled', 'disabled');
                        $('.operator_id').removeAttr('required');
                    }

                    $.get('/operators/select', function(data) {
                        $('.operator_id').empty();
                        $('.operator_id').append("<option value=''>Seleccione Operador...</option>");
                        $.each(data, function(index, subOperatorObj) {
                            $('.operator_id').append("<option value='" + subOperatorObj.id + "'>" +
                                subOperatorObj.description + "</option>");
                        });
                        $(".operator_id option[value=" + document.getElementById("operator_id_support")
                            .value + "]").attr("selected", true);
                    });
                    break;

                case 'Term':
                    $(".term").attr("style", "display:block");
                    $('.term_id').removeAttr('disabled');
                    $('.term_id').attr('required', true);

                    type_condition = document.getElementById("type_condition_support").value;
                    $.get('/terms/select?type_condition=' + type_condition, function(data) {
                        $('.term_id').empty();
                        $('.term_id').append("<option value=''>Seleccione Condición Comercial...</option>");
                        $.each(data, function(index, subTermObj) {
                            $('.term_id').append("<option value='" + subTermObj.id + "'>" +
                                subTermObj.description + "</option>");
                        });
                        $(".term_id option[value=" + document.getElementById("term_id_support").value + "]")
                            .attr("selected", true);
                    });
                    break;

                case 'Affiliation':
                    $(".affiliation").attr("style", "display:block");
                    $('#type_dcustomer').removeAttr('disabled');
                    $('#type_dcustomer').attr('required', true);
                    $('#type_dcustomer').empty();
                    $('#type_dcustomer').append("<option value=''>Seleccionar Tipo Afiliación...</option>");
                    $('#type_dcustomer').append("<option value='commerce'>Comercio Básico</option>");
                    $('#type_dcustomer').append("<option value='nodom'>Pago No Domiciliado</option>");
                    $("#type_dcustomer option[value=" + document.getElementById("type_dcustomer_support").value +
                        "]").attr("selected", true);

                    $.get('/dcustomers/select?customer_id=' + parseFloat(document.getElementById("customer_id")
                            .value) + '&type_dcustomer=' + document.getElementById("type_dcustomer_support")
                        .value,
                        function(data) {
                            if (document.getElementById("type_dcustomer_support").value == 'commerce' ||
                                document.getElementById("type_dcustomer_support").value == 'nodom') {
                                $(".dcustomer").attr("style", "display:block");
                                $(".dmultiple").attr("style", "display:none");

                                $('#dcustomer_id').removeAttr('disabled');
                                $('#negotiation_id').removeAttr('disabled');

                                $('#dcustomer_id').empty();
                                $('#dcustomer_id').append(
                                    "<option value=''>Seleccione No. Afiliación...</option>");
                                $.each(data, function(index, subAffObj) {
                                    $('#dcustomer_id').append("<option value='" + subAffObj.id + "'>" +
                                        subAffObj.description + "</option>");
                                });
                                $("#dcustomer_id option[value=" + document.getElementById(
                                    "dcustomer_id_support").value + "]").attr("selected", true);

                                document.getElementById("type_condition_support").value = 'Fijo';
                            }
                        });
                    break;

                case 'ModelTerminal':
                    $(".modelterminal").attr("style", "display:block");
                    $('.modelterminal_id').removeAttr('disabled');
                    $('.modelterminal_id').attr('required', true);
                    $.get('/mterminals/select?filter=active', function(data) {
                        $('.modelterminal_id').empty();
                        $('.modelterminal_id').append(
                            "<option value=''>Seleccione Modelo Terminal...</option>");
                        $.each(data, function(index, subMterminalObj) {
                            $('.modelterminal_id').append("<option value='" + subMterminalObj.id +
                                "'>" + subMterminalObj.description + "</option>");
                        });
                        $(".modelterminal_id option[value=" + document.getElementById(
                            "modelterminal_id_support").value + "]").attr("selected", true);
                    });
                    break;

                case 'TerminalChange':
                    $(".terminal").attr("style", "display:block");
                    $.get('/companies/select/zone-valid?slug=sales.consultant&wholesaler=0', function(data) {
                        $('#company_change_id').empty();
                        $('#company_change_id').append("<option value=''>Seleccione Almacén...</option>");

                        $.each(data, function(index, subCompanyObj) {
                            $('#company_change_id').append("<option value='" + subCompanyObj.id +
                                "'>" + subCompanyObj.description + "</option>");
                        });
                    });

                    $('.company_change_id').removeAttr('disabled');
                    $('.company_change_id').attr('required', true);

                    $('.modelTerminal_change_id').removeAttr('disabled');
                    $('.modelTerminal_change_id').attr('required', true);

                    $.get('/mterminals/select?filter=active', function(data) {
                        $('#modelTerminal_change_id').empty();
                        $('#modelTerminal_change_id').append(
                            "<option value=''>Seleccione Modelo Terminal...</option>");
                        $.each(data, function(index, subMterminalObj) {
                            $('#modelTerminal_change_id').append("<option value='" + subMterminalObj
                                .id + "'>" + subMterminalObj.description + "</option>");
                        });
                    });

                    $('.terminal_change_id').removeAttr('disabled');
                    $('.terminal_change_id').attr('required', true);
                    break;

                case 'SimcardChange':
                    $(".simcard").attr("style", "display:block");
                    $('.company_change_id').removeAttr('disabled');
                    $('.company_change_id').attr('required', true);

                    $.get('/companies/select/zone-valid?slug=sales.consultant&wholesaler=0', function(data) {
                        $('#company_change_id').empty();
                        $('#company_change_id').append("<option value=''>Seleccione Almacén...</option>");

                        $.each(data, function(index, subCompanyObj) {
                            $('#company_change_id').append("<option value='" + subCompanyObj.id +
                                "'>" + subCompanyObj.description + "</option>");
                        });
                    });

                    $('.operator_change_id').removeAttr('disabled');
                    $('.operator_change_id').attr('required', true);

                    $.get('/operators/select', function(data) {
                        $('#operator_change_id').empty();
                        $('#operator_change_id').append("<option value=''>Seleccione Operador...</option>");
                        $.each(data, function(index, subOperatorObj) {
                            $('#operator_change_id').append("<option value='" + subOperatorObj.id +
                                "'>" + subOperatorObj.description + "</option>");
                        });
                    });

                    $('.simcard_change_id').removeAttr('disabled');
                    $('.simcard_change_id').attr('required', true);
                    break;

                case 'User':
                    $(".sale_user").attr("style", "display:block");
                    $('.user_id').removeAttr('disabled');
                    $('.user_id').attr('required', true);

                    $('.consultant_id').removeAttr('disabled');

                    $.get('/roles/getrole', function(data) {
                        var user_id = document.getElementById("user_created_id_support").value;
                        var slug = data.slug;

                        $.get('/users/select?slug=' + slug + '&user_id=' + user_id, function(data) {
                            $('#user_id').empty();
                            if (data.length > 1) {
                                $('#user_id').append(
                                    "<option value=''>Seleccione Asesor Venta...</option>");
                            }
                            $.each(data, function(index, subUserObj) {
                                $('#user_id').append("<option value='" + subUserObj.id +
                                    "'>" + subUserObj.description + "</option>");
                            });
                            $("#user_id option[value=" + document.getElementById(
                                "user_created_id_support").value + "]").attr("selected", true);

                            if (document.getElementById("consultant_id_support").value != '') {
                                $.get('/consultants/select?user_id=' + user_id, function(data) {
                                    $('#consultant_id').empty();
                                    $('#consultant_id').append(
                                        "<option value=''>Seleccione Aliado Comercial...</option>"
                                    );
                                    $.each(data, function(index, subUserObj) {
                                        $('#consultant_id').append(
                                            "<option value='" + subUserObj.id +
                                            "'>" + subUserObj.description +
                                            "</option>");
                                    });
                                    $("#consultant_id option[value=" + document
                                        .getElementById("consultant_id_support").value +
                                        "]").attr("selected", true);
                                });
                            }
                        });
                    });
                    break;
            }
        });
        /****************************************************************************/
        $('#type_dcustomer').on('change', function(e) {
            var customer_id = document.getElementById("customer_id").value;
            var type_dcustomer = document.getElementById("type_dcustomer").value;
            $.get('/dcustomers/select?customer_id=' + parseFloat(customer_id) + '&type_dcustomer=' + type_dcustomer,
                function(data) {
                    if (type_dcustomer == 'commerce' || type_dcustomer == 'nodom') {
                        $(".dcustomer").attr("style", "display:block");
                        $('.dcustomer').removeAttr('disabled');
                        $('.dcustomer').attr('required', true);

                        $(".dmultiple").attr("style", "display:none");
                        $('.dmultiple').attr('disabled', 'disabled');
                        $('.dmultiple').removeAttr('required');

                        $('#dcustomer_id').empty();
                        $('#dcustomer_id').append("<option value=''>Seleccione No. Afiliación...</option>");
                        $.each(data, function(index, subAffObj) {
                            $('#dcustomer_id').append("<option value='" + subAffObj.id + "'>" +
                                subAffObj.description + "</option>");
                        });
                        document.getElementById("type_condition_support").value = 'Fijo';
                    }
                });
        });
        /****************************************************************************/
        $('.user_id').on('change', function(e) {
            var user_id = e.target.value;
            $.get('/consultants/select?user_id=' + user_id, function(data) {
                $('#consultant_id').empty();
                if (data.length > 0) {
                    $('#consultant_id').append("<option value=''>Seleccione Aliado Comercial...</option>");
                    $.each(data, function(index, subUserObj) {
                        $('#consultant_id').append("<option value='" + subUserObj.id + "'>" +
                            subUserObj.description + "</option>");
                    });
                } else {
                    document.getElementById("consultant_id").readonly = true;
                    $('#consultant_id').append("<option value=''>Ningún Aliado Comercial</option>");
                }
            });
        });
        /****************************************************************************/
        $('.search_terminal').on('change', function(e) {
            var company = document.getElementById("company_change_id").value;
            var mterminal = document.getElementById("modelTerminal_change_id").value;
            $.get('/terminals/select/available?company_id=' + company + '&mterminal_id=' + mterminal + '&destino=',
                function(data) {
                    $('#terminal_change_id').empty();
                    $('#terminal_change_id').append("<option value=''>Seleccione Terminal...</option>");
                    $.each(data, function(index, subterminalObj) {
                        $('#terminal_change_id').append("<option value='" + subterminalObj.id + "'>" +
                            subterminalObj.description + "</option>");
                    });
                });
        });
        /****************************************************************************/
        $('.search_simcard').on('change', function(e) {
            var company = document.getElementById("company_change_id").value;
            var operator = document.getElementById("operator_change_id").value;

            $.get('/simcards/select/available?company_id=' + company + '&operator_id=' + operator + '&destino=',
                function(data) {
                    $('#simcard_change_id').empty();
                    $('#simcard_change_id').append("<option value=''>Seleccione Simcard...</option>");
                    $.each(data, function(index, subOperatorObj) {
                        $('#simcard_change_id').append("<option value='" + subOperatorObj.id + "'>" +
                            subOperatorObj.description + "</option>");
                    });
                });
        });
        /****************************************************************************/
        function checkinput() {
            if ($('#simcard_checkbox')[0].checked == false) {
                $('#operator_id').removeAttr('disabled');
                $('#operator_id').attr('required', true);
            } else {
                $('#operator_id').attr('disabled', 'disabled');
                $('#operator_id').removeAttr('required');
            }
        }
        /****************************************************************************/
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
        /****************************************************************************/
        $('.numberl').mask('AAAAAAAAAA', {
            'translation': {
                A: {
                    pattern: /[0-9]/
                }
            }
        });
        /****************************************************************************/
        $('.text').keyup(function() {
            this.value = this.value.toUpperCase();
        });
        /****************************************************************************/
        $('.numbert').mask('AAA', {
            'translation': {
                A: {
                    pattern: /[0-9]/
                }
            }
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
    </script>
@endsection
