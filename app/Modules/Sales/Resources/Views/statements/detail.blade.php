@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/sweetalert2.min.css') }}">
    <link href="/assets/css/select2.min.css" rel="stylesheet" />
    <!-- Plugins css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/style.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/index.js"></script>
    <style>
        .statement {
            height: 400px;
            /* Just for the demo          */
            overflow-y: auto;
            /* Trigger vertical scroll    */
            overflow-x: hidden;
            /* Hide the horizontal scroll */
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
                    {!! Form::open(['id' => 'form']) !!}
                    <div class="col-md-12 row">
                        <div class="col-sm-12 p-2">
                            <h5><b>Consultar Cliente</b></h5>
                        </div>
                        <div class="col-sm-11">
                            <select class="search form-control form-control-rounded" id="search" name="search"></select>
                        </div>

                        <div class="col-sm-1">
                            <a href="#" name="find" class="btn btn-sm btn-fill btn-dark find">Consultar</a>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row contract" style="display:none">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    {!! Form::open(['id' => 'form']) !!}
                    <div class="col-md-12 row">
                        <div class="col-sm-12 p-2">
                            <h5><b>Información Cliente</b></h5>
                        </div>
                        <div class="col-sm-2 p-2">
                            <label for="foreign_id" class="col-sm-12"><b>Código Profit</b></label>
                            {!! form::text('foreign_id', null, [
                                'id' => 'foreign_id',
                                'class' => 'form-control',
                                'readonly' => 'readonly',
                                'value' => old('customer_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>
                        <div class="col-sm-2 p-2">
                            <label for="customer_id" class="col-sm-12"><b>Código</b></label>
                            {!! form::text('customer_id', null, [
                                'id' => 'customer_id',
                                'class' => 'form-control input',
                                'readonly' => 'readonly',
                            ]) !!}
                        </div>
                        <div class="col-sm-2 p-2">
                            <label for="rif" class="col-sm-12"><b>RIF</b></label>
                            {!! form::text('rif', null, ['id' => 'rif', 'class' => 'form-control input', 'readonly' => 'readonly']) !!}
                        </div>
                        <div class="col-sm-6 p-2">
                            <label for="bussiness_name" class="col-sm-12"><b>Comercio</b></label>
                            {!! form::text('business_name', null, [
                                'id' => 'business_name',
                                'class' => 'form-control input',
                                'readonly' => 'readonly',
                            ]) !!}
                        </div>
                        <div class="col-sm-2 p-2">
                            <label for="state" class="col-sm-12"><b>Estado</b></label>
                            {!! form::text('state', null, ['id' => 'state', 'class' => 'form-control input', 'readonly' => 'readonly']) !!}
                        </div>
                        <div class="col-sm-2 p-2">
                            <label for="city" class="col-sm-12"><b>Ciudad</b></label>
                            {!! form::text('city', null, ['id' => 'city', 'class' => 'form-control input', 'readonly' => 'readonly']) !!}
                        </div>
                        <div class="col-sm-2 p-2">
                            <label for="municipality" class="col-sm-12"><b>Municipalidad</b></label>
                            {!! form::text('municipality', null, [
                                'id' => 'municipality',
                                'class' => 'form-control input',
                                'readonly' => 'readonly',
                            ]) !!}
                        </div>
                        <div class="col-sm-4 p-2">
                            <label for="address" class="col-sm-12"><b>Dirección Residencia</b></label>
                            {!! form::text('address', null, ['id' => 'address', 'class' => 'form-control input', 'readonly' => 'readonly']) !!}
                        </div>
                        <div class="col-sm-2 p-2">
                            <label for="postal_code" class="col-sm-12"><b>Código Postal</b></label>
                            {!! form::text('postal_code', null, [
                                'id' => 'postal_code',
                                'class' => 'form-control input',
                                'readonly' => 'readonly',
                            ]) !!}
                        </div>
                        <div class="col-sm-3 p-2">
                            <label for="email" class="col-sm-12"><b>Email</b></label>
                            {!! form::text('email', null, ['id' => 'email', 'class' => 'form-control input', 'readonly' => 'readonly']) !!}
                        </div>
                        <div class="col-sm-2 p-2">
                            <label for="mobile" class="col-sm-12"><b>Móvil</b></label>
                            {!! form::text('mobile', null, ['id' => 'mobile', 'class' => 'form-control input', 'readonly' => 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <hr>
                        <div class="col-sm-12 p-2">
                            <h5><b>Información Contrato</b></h5>
                        </div>
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
                                </tr>
                            </thead>
                        </table>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row contract" style="display:none;">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="col-sm-12">
                        <!-- basic accordions with icons -->
                        <div class="accordion" id="accordionRightIcon">
                            <div class="card">
                                <div class="card-header header-elements-inline">
                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                        <a data-toggle="collapse" class="text-default collapsed"
                                            href="#accordion-item-icons-0">
                                            <span><i class="i-Data-File-Chart ul-accordion__font"> </i></span> Estado de
                                            Cuenta
                                        </a>
                                    </h6>
                                </div>
                                <div id="accordion-item-icons-0" class="collapse " data-parent="#accordionRightIcon">
                                    <div class="card-body">
                                        <div class="statements" style="display: none;">
                                            <div class="col-sm-12 row">
                                                <div class="col-sm-3">
                                                    <form>
                                                        <center>
                                                            <input type="hidden" name="contract_id" id="contract_id">
                                                            <input id="date_invoice" name="date_invoice" type="text"
                                                                class="form-control input date_invoice"
                                                                placeholder="yyyy-mm" data-toggle="datepicker"
                                                                readonly><br>
                                                            <a id="statements-export" href="#"
                                                                name="statements-export"
                                                                class="btn btn-sm btn-dark statements-export">Descargar
                                                                PDF</a>
                                                            <a id="statements-export-excel" href="#"
                                                                name="statements-export-excel"
                                                                class="btn btn-sm btn-dark statements-export">Descargar
                                                                Excel</a>
                                                        </center>
                                                    </form>
                                                </div>
                                                <div class="col-sm-3">
                                                    <center>
                                                        <h5><b>Cargos $. </b>
                                                            <div id="total_invoice" name="total_invoice"></div>
                                                        </h5>
                                                    </center>
                                                </div>
                                                <div class="col-sm-3">
                                                    <center>
                                                        <h5><b>Abonos $. </b>
                                                            <div id="total_collection" name="total_collection"></div>
                                                        </h5>
                                                    </center>
                                                </div>
                                                <div class="col-sm-3">
                                                    <center>
                                                        <h5><b>Balance $. </b>
                                                            <div id="balance" name="balance"></div>
                                                        </h5>
                                                    </center>
                                                </div>
                                                <div class="col-sm-12">
                                                    <hr>
                                                    <table id="statements-detail" name="statements-detail"
                                                        class="table table-striped table-bordered table-responsive statement"
                                                        cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <center>No. Cobro</center>
                                                                </th>
                                                                <th>
                                                                    <center>No. Pago</center>
                                                                </th>
                                                                <th>
                                                                    <center>Fecha Operación</center>
                                                                </th>
                                                                <th>
                                                                    <center>Tipo Operación</center>
                                                                </th>
                                                                <th>
                                                                    <center>Monto $</center>
                                                                </th>
                                                                <th>
                                                                    <center>Tarifa Cambio</center>
                                                                </th>
                                                                <th>
                                                                    <center>Monto Bs.</center>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="statements-empty" style="display: none;">
                                            <center>
                                                <h5><b>No hay Información de Gestión Realizada</b></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header header-elements-inline">
                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                        <a data-toggle="collapse" class="text-default collapsed"
                                            href="#accordion-item-icons-5">
                                            <span><i class="i-smartphone ul-accordion__font"> </i></span> Promesa Pago
                                        </a>
                                    </h6>
                                </div>
                                <div id="accordion-item-icons-5" class="collapse " data-parent="#accordionRightIcon">
                                    <div class="card-body">
                                        <div class="promise" style="display: none;">
                                            <table id="promise-payment" name="promise-payment"
                                                class="table table-striped table-bordered table-responsive statement"
                                                cellspacing="0" width="100%" style="display:none;">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <center>#</center>
                                                        </th>
                                                        <th>
                                                            <center>#</center>
                                                        </th>
                                                        <th>
                                                            <center>#</center>
                                                        </th>
                                                        <th>
                                                            <center>#</center>
                                                        </th>
                                                        <th>
                                                            <center>#</center>
                                                        </th>
                                                        <th>
                                                            <center>#</center>
                                                        </th>
                                                        <th>
                                                            <center>#</center>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="promise-empty" style="display: block;">
                                            <center>
                                                <h5><b>No hay Información de Gestión Realizada</b></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header header-elements-inline">
                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                        <a data-toggle="collapse" class="text-default collapsed"
                                            href="#accordion-item-icons-1" aria-expanded="false">
                                            <span><i class="i-Big-Headset ul-accordion__font"> </i></span>Gestión
                                            Domiciliación Bancaria
                                        </a>
                                    </h6>
                                </div>
                                <div id="accordion-item-icons-1" class="collapse " data-parent="#accordionRightIcon"
                                    style="">
                                    <div class="card-body">
                                        <div class="domiciliations" style="display: none;">
                                            <center>
                                                <table id="domiciliation-bank" name="domiciliation-bank"
                                                    class="table table-striped table-bordered table-responsive statement"
                                                    cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <center>No. Cobro</center>
                                                            </th>
                                                            <th>
                                                                <center>Fecha Cobro</center>
                                                            </th>
                                                            <th>
                                                                <center>Monto $</center>
                                                            </th>
                                                            <th>
                                                                <center>Cambio Divisa Bs.</center>
                                                            </th>
                                                            <th>
                                                                <center>Monto Bs.</center>
                                                            </th>
                                                            <th>
                                                                <center>Descripción</center>
                                                            </th>
                                                            <th>
                                                                <center>No. Pago</center>
                                                            </th>
                                                            <th>
                                                                <center>Fecha Pago</center>
                                                            </th>
                                                            <th>
                                                                <center>Respuesta</center>
                                                            </th>
                                                            <th>
                                                                <center>Status Proceso</center>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </center>
                                        </div>
                                        <div class="domiciliations-empty" style="display: none;">
                                            <center>
                                                <h5><b>No hay Información de Gestión Realizada</b></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header header-elements-inline">
                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                        <a data-toggle="collapse" class="text-default collapsed"
                                            href="#accordion-item-icons-2">
                                            <span><i class="i-Data-File-Chart ul-accordion__font"> </i></span>Gestión
                                            Operación Cobranza
                                        </a>
                                    </h6>
                                </div>
                                <div id="accordion-item-icons-2" class="collapse " data-parent="#accordionRightIcon">
                                    <div class="card-body">
                                        <div class="operations" style="display: none;">
                                            <table id="operations-detail" name="operations-detail"
                                                class="table table-striped table-bordered table-responsive statement"
                                                cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <center>#</center>
                                                        </th>
                                                        <th>
                                                            <center>Fecha</center>
                                                        </th>
                                                        <th>
                                                            <center>Tipo Operación</center>
                                                        </th>
                                                        <th>
                                                            <center>Fecha Cobro</center>
                                                        </th>
                                                        <th>
                                                            <center>No. Contrato</center>
                                                        </th>
                                                        <th>
                                                            <center>No. Cobro</center>
                                                        </th>
                                                        <th>
                                                            <center>Monto $.</center>
                                                        </th>
                                                        <th>
                                                            <center>Obs. Carga</center>
                                                        </th>
                                                        <th>
                                                            <center>Respuesta</center>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="operations-empty" style="display: none;">
                                            <center>
                                                <h5><b>No hay Información de Gestión Realizada</b></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header header-elements-inline">
                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                        <a data-toggle="collapse" class="text-default collapsed"
                                            href="#accordion-item-icons-3">
                                            <span><i class="i-smartphone ul-accordion__font"> </i></span>Gestión Terminal
                                        </a>
                                    </h6>
                                </div>
                                <div id="accordion-item-icons-3" class="collapse " data-parent="#accordionRightIcon">
                                    <div class="card-body">
                                        <div class="operterminals" style="display: none;">
                                            <table id="operterminals-detail" name="operterminals-detail"
                                                class="table table-striped table-bordered table-responsive statement"
                                                cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <center>#</center>
                                                        </th>
                                                        <th>
                                                            <center>Fecha</center>
                                                        </th>
                                                        <th>
                                                            <center>Tipo Gestión</center>
                                                        </th>
                                                        <th>
                                                            <center>Operación</center>
                                                        </th>
                                                        <th>
                                                            <center>Plan Actual</center>
                                                        </th>
                                                        <th>
                                                            <center>Plan Cambio</center>
                                                        </th>
                                                        <th>
                                                            <center>Serial Terminal</center>
                                                        </th>
                                                        <th>
                                                            <center>Suspensión</center>
                                                        </th>
                                                        <th>
                                                            <center>Reactivación</center>
                                                        </th>
                                                        <th>
                                                            <center>Observación</center>
                                                        </th>
                                                        <th>
                                                            <center>Status Gestión</center>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="operterminals-empty" style="display: block;">
                                            <center>
                                                <h5><b>No hay Información de Gestión Realizada</b></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header header-elements-inline">
                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                        <a data-toggle="collapse" class="text-default collapsed"
                                            href="#accordion-item-icons-6">
                                            <span><i class="i-Billing ul-accordion__font"> </i></span> Facturas
                                        </a>
                                    </h6>
                                </div>
                                <div id="accordion-item-icons-6" class="collapse " data-parent="#accordionRightIcon">
                                    <div class="card-body">
                                        <div class="billings" style="display: none;">
                                            <table id="billings-detail" name="billings-detail"
                                                class="table table-striped table-bordered table-responsive statement"
                                                cellspacing="0" width="100%" style="display:none;">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <center>#</center>
                                                        </th>
                                                        <th>
                                                            <center>#</center>
                                                        </th>
                                                        <th>
                                                            <center>#</center>
                                                        </th>
                                                        <th>
                                                            <center>#</center>
                                                        </th>
                                                        <th>
                                                            <center>#</center>
                                                        </th>
                                                        <th>
                                                            <center>#</center>
                                                        </th>
                                                        <th>
                                                            <center>#</center>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="billings-empty" style="display: block;">
                                            <center>
                                                <h5><b>No hay Información de Gestión Realizada</b></h5>
                                        </div>
                                    </div>
                                </div>
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
    <script src="/assets/js/select2.min.js"></script>

    @toastr_js
    @toastr_render

    <script type="text/javascript">
        flatpickr(".date_invoice", {
            dateFormat: "Y-m",
            plugins: [
                new monthSelectPlugin({
                    shorthand: true, //defaults to false
                    dateFormat: "Y-m", //defaults to "F Y"
                    altFormat: "F Y", //defaults to "F Y"
                    theme: "light" // defaults to "light"
                }),
            ],
        });
        /****************************************************************************/
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
        });
        /**************************************************************************/
        function findContract(find) {
            if (find != '') {
                $.get('/statements/getInformationCustomer?find=' + find, function(data) {
                    if (data) {
                        var contract_id = data[0].contract_id;
                        var bank_id = data[0].bank_id;
                        $(".contract").attr("style", "display:block");

                        $("#id").val(data[0].contract_id);
                        $("#contract_id").val(data[0].contract_id);
                        $("#foreign_id").val(data[0].foreign_id);
                        $("#customer_id").val(data[0].customer_id);
                        $("#rif").val(data[0].rif);
                        $("#business_name").val(data[0].business_name);
                        $("#state").val(data[0].state);
                        $("#city").val(data[0].city);
                        $("#municipality").val(data[0].municipality);
                        $("#address").val(data[0].address);
                        $("#mobile").val(data[0].mobile);
                        $("#postal_code").val(data[0].email);
                        $("#email").val(data[0].postal_code);
                        $("#postal_code").val(data[0].postal_code);
                        $("#mobile").val(data[0].mobile);

                        $('#contracts-detail > tbody').empty();
                        var tbl = document.getElementById("contracts-detail");
                        var tblBody = document.createElement("tbody");
                        var fila = document.createElement("tr");

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[0].contract_id);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        let div = document.createElement('div');
                        div.innerHTML = data[0].statusc;
                        celda.appendChild(div);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[0].created);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[0].posted);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[0].company);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[0].bank);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[0].affiliate_number);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[0].modelterminal);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[0].terminal);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[0].nropos);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[0].operator);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[0].simcard);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[0].term);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[0].user);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[0].consultant);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        tblBody.appendChild(fila);
                        tbl.appendChild(tblBody);
                        tbl.setAttribute("border", "2");
                        /****************************************************************/
                        $.get('/statements/getHistorialManagement?contract_id=' + contract_id, function(data) {
                            if (data.length > 0) {
                                var invoice = 0;
                                var collection = 0;

                                $(".statements").attr("style", "display:block");
                                $(".statements-empty").attr("style", "display:none");
                                $(".statements-export").attr("href",
                                    '/statements/export?date=&contract_id=' + contract_id);
                                $(".statements-exportExcel").attr("href",
                                    '/statements/exportExcel?date=&contract_id=' + contract_id);
                                $('#statements-detail > tbody').empty();
                                var tbl = document.getElementById("statements-detail");
                                var tblBody = document.createElement("tbody");

                                $.each(data, function(index, subStatementObj) {
                                    if (subStatementObj.type_abrev == 'C') {
                                        invoice = parseFloat(invoice) + parseFloat(subStatementObj
                                            .amount);
                                    } else
                                    if (subStatementObj.type_abrev == 'P') {
                                        collection = parseFloat(collection) + parseFloat(
                                            subStatementObj.amount);
                                    }

                                    var fila = document.createElement("tr");

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subStatementObj.id);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subStatementObj
                                        .collection_id);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subStatementObj.date);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subStatementObj.type);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subStatementObj
                                        .amount != '----' ? new Intl.NumberFormat("en-US")
                                        .format(subStatementObj.amount) : '----');
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subStatementObj
                                        .dicom != '----' ? new Intl.NumberFormat("en-US")
                                        .format(subStatementObj.dicom) : '----');
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subStatementObj
                                        .amount_currency != '----' ? new Intl.NumberFormat(
                                            "en-US").format(subStatementObj.amount_currency) :
                                        '----');
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    tblBody.appendChild(fila);
                                    tbl.appendChild(tblBody);
                                    tbl.setAttribute("border", "2");
                                });

                                var total = (parseFloat(invoice) - parseFloat(collection));
                                document.getElementById("total_invoice").innerHTML = new Intl.NumberFormat(
                                    "en-US").format(invoice);
                                document.getElementById("total_collection").innerHTML = new Intl
                                    .NumberFormat("en-US").format(collection);
                                document.getElementById("balance").innerHTML = new Intl.NumberFormat(
                                    "en-US").format(total);
                            } else {
                                $(".statements").attr("style", "display:none");
                                $(".statements-empty").attr("style", "display:block");
                            }
                        });
                        /**************************************************************/
                        $.get('/statements/getHistorialDomiciliationOperation?contract_id=' + contract_id, function(
                            data) {
                            if (data.length > 0) {
                                $(".operations").attr("style", "display:block");
                                $(".operations-empty").attr("style", "display:none");

                                $('#operations-detail > tbody').empty();
                                var tbl = document.getElementById("operations-detail");
                                var tblBody = document.createElement("tbody");

                                $.each(data, function(index, subOperationObj) {
                                    var fila = document.createElement("tr");

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subOperationObj.id);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subOperationObj
                                        .created);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subOperationObj
                                        .type_operation);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subOperationObj
                                        .fechpro);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subOperationObj
                                        .contract_id);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subOperationObj
                                        .invoice_id);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subOperationObj
                                        .amount != '----' ? new Intl.NumberFormat("en-US")
                                        .format(subOperationObj.amount) : '----');
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subOperationObj
                                        .observations);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subOperationObj
                                        .observation_response);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    tblBody.appendChild(fila);
                                    tbl.appendChild(tblBody);
                                    tbl.setAttribute("border", "2");
                                });
                            } else {
                                $(".operations").attr("style", "display:none");
                                $(".operations-empty").attr("style", "display:block");
                            }
                        });
                        /**************************************************************/
                        // $.get('/statements/getHistorialDomiciliationBank?bank_id='+bank_id+'&contract_id='+contract_id, function(data) {
                        //   if(data.length > 0){
                        //     $(".domiciliations").attr("style", "display:block");
                        //     $(".domiciliations-empty").attr("style", "display:none");

                        //     $('#domiciliation-bank > tbody').empty();
                        //     var tbl = document.getElementById("domiciliation-bank");
                        //     var tblBody = document.createElement("tbody");

                        //     $.each(data, function(index, subRcollectionObj) {
                        //       var fila = document.createElement("tr");

                        //       var celda = document.createElement("td");
                        //       var textoCelda = document.createTextNode(subRcollectionObj.invoice_id);
                        //       celda.appendChild(textoCelda);
                        //       fila.appendChild(celda);

                        //       var celda = document.createElement("td");
                        //       var textoCelda = document.createTextNode(subRcollectionObj.fechpro);
                        //       celda.appendChild(textoCelda);
                        //       fila.appendChild(celda);

                        //       var celda = document.createElement("td");
                        //       var textoCelda = document.createTextNode(subRcollectionObj.amount != '----' ? new Intl.NumberFormat("en-US").format(subRcollectionObj.amount) : '----');
                        //       celda.appendChild(textoCelda);
                        //       fila.appendChild(celda);

                        //       var celda = document.createElement("td");
                        //       var textoCelda = document.createTextNode(subRcollectionObj.currency != '----' ? new Intl.NumberFormat("en-US").format(subRcollectionObj.currency) : '----');
                        //       celda.appendChild(textoCelda);
                        //       fila.appendChild(celda);

                        //       var celda = document.createElement("td");
                        //       var textoCelda = document.createTextNode(subRcollectionObj.amount_currency != '----' ? new Intl.NumberFormat("en-US").format(subRcollectionObj.amount_currency) : '----');
                        //       celda.appendChild(textoCelda);
                        //       fila.appendChild(celda);

                        //       var celda = document.createElement("td");
                        //       var textoCelda = document.createTextNode(subRcollectionObj.descripcion_cliente);
                        //       celda.appendChild(textoCelda);
                        //       fila.appendChild(celda);

                        //       var celda = document.createElement("td");
                        //       var textoCelda = document.createTextNode(subRcollectionObj.collection_id);
                        //       celda.appendChild(textoCelda);
                        //       fila.appendChild(celda);

                        //       var celda = document.createElement("td");
                        //       var textoCelda = document.createTextNode(subRcollectionObj.fechpro_collection);
                        //       celda.appendChild(textoCelda);
                        //       fila.appendChild(celda);

                        //       var celda = document.createElement("td");
                        //       var textoCelda = document.createTextNode(subRcollectionObj.motivo_del_fallido);
                        //       celda.appendChild(textoCelda);
                        //       fila.appendChild(celda);

                        //       var celda = document.createElement("td");
                        //       var textoCelda = document.createTextNode(subRcollectionObj.status);
                        //       celda.appendChild(textoCelda);
                        //       fila.appendChild(celda);

                        //       tblBody.appendChild(fila);
                        //       tbl.appendChild(tblBody);
                        //       tbl.setAttribute("border", "2");
                        //     });
                        //   }else{
                        //     $(".domiciliations").attr("style", "display:none");
                        //     $(".domiciliations-empty").attr("style", "display:block");
                        //   }
                        // });
                        /**************************************************************/
                        $.get('/statements/getHistorialOperterminal?contract_id=' + contract_id, function(data) {
                            if (data.length > 0) {
                                $(".operterminals").attr("style", "display:block");
                                $(".operterminals-empty").attr("style", "display:none");

                                $('#operterminals-detail > tbody').empty();
                                var tbl = document.getElementById("operterminals-detail");
                                var tblBody = document.createElement("tbody");

                                $.each(data, function(index, subOperterminalObj) {
                                    var fila = document.createElement("tr");

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subOperterminalObj
                                        .operterminal_id);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subOperterminalObj
                                        .fechpro);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subOperterminalObj
                                        .type);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subOperterminalObj
                                        .type_operation);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subOperterminalObj
                                        .term_name);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subOperterminalObj
                                        .term_change);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subOperterminalObj
                                        .serial_terminal);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subOperterminalObj
                                        .inactive);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subOperterminalObj
                                        .reactive);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subOperterminalObj
                                        .observations);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    var celda = document.createElement("td");
                                    var textoCelda = document.createTextNode(subOperterminalObj
                                        .status_operterminal);
                                    celda.appendChild(textoCelda);
                                    fila.appendChild(celda);

                                    tblBody.appendChild(fila);
                                    tbl.appendChild(tblBody);
                                    tbl.setAttribute("border", "2");
                                });
                            } else {
                                $(".operterminals").attr("style", "display:none");
                                $(".operterminals-empty").attr("style", "display:block");
                            }
                        });
                    }
                });
            } else {
                $(".contract").attr("style", "display:none");
                $('#contracts-detail > tbody').empty();
                $('#statements-detail > tbody').empty();
                $('#promise-payment > tbody').empty();
                $('#domiciliation-bank > tbody').empty();
                $('#operations-detail > tbody').empty();
                $('#operterminals-detail > tbody').empty();
                $('#billing-detail > tbody').empty();
                $(".input").val('');
                swal('', 'Por favor Ingrese información para Iniciar Búsqueda', 'info');
            }
        }
        /**************************************************************************/
        $('.find').on('click', function(e) {
            var find = document.getElementById("search").value;
            findContract(find);
        });

        $('#statements-export').on('click', function(e) {
            var date = document.getElementById("date_invoice").value;
            var contract_id = document.getElementById("contract_id").value;
            $("#statements-export").attr("href", '/statements/export?date=' + date + '&contract_id=' +
                contract_id);
        });
        $('#statements-export-excel').on('click', function(e) {
            var date = document.getElementById("date_invoice").value;
            var contract_id = document.getElementById("contract_id").value;
            $("#statements-export-excel").attr("href", '/statements/exportExcel?date=' + date + '&contract_id=' +
                contract_id);
        });
    </script>
@endsection
