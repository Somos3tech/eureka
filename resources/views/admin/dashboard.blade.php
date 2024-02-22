@extends('layouts.compact-master')

@section('page-css')
    @toastr_css
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = false;

        var pusher = new Pusher('9c5adc53b2e448ef6001', {
            cluster: 'mt1'
        });

        var channel = pusher.subscribe('currencyvalue');
        channel.bind('rate-currencyvalue', function(data) {
            $(".currencyvalue").empty();
            $.each(data, function(index, subCurrencyvalueObj) {
                $("#last").append('Bs. ' + subCurrencyvalueObj.value);
                $("#last_date").append(subCurrencyvalueObj.date_value);
            });
            toastr.info("Tarifa de Cambio ha sido Actualizada")
        });

        var channel2 = pusher.subscribe('preafiliation');
        channel2.bind('total-preafiliation', function(data) {
            $(".preafiliation").empty();
            $("#preafiliation").append('<b>' + data.preafiliation + '</b>');
            toastr.info("Registro Preafiliación fue  registrado o procesado")
        });

        var channel3 = pusher.subscribe('terminalvalue');
        channel3.bind('rate-terminalvalue', function(data) {
            $(".terminalvalue").empty();
            $.get('/terminalvalues/getLast', function(data) {
                var tbl = document.getElementById("terminalvalue_card");
                var ul = document.createElement("ul");
                ul.setAttribute("class", "list-inline widget-chart text-center");

                $.each(data, function(index, subTerminalValueObj) {
                    var li = document.createElement("li");
                    li.setAttribute("class", "list-inline-item p-4");

                    var celda = document.createElement("h6");
                    var span = document.createElement("span"); // Create a <p> element
                    span.innerHTML = '<div class="currency_value"><b>' + subTerminalValueObj
                        .amount_currency + ' | ' + subTerminalValueObj.amount_local + '</b></div>';
                    celda.appendChild(span);
                    li.appendChild(celda);

                    var celda = document.createElement("div");
                    var celda2 = document.createElement("b");
                    var span = document.createElement("span"); // Create a <p> element
                    span.innerHTML = '<b>' + subTerminalValueObj.modelTerminal + '</b><br>';
                    celda2.appendChild(span);
                    celda.appendChild(celda2);
                    li.appendChild(celda);

                    var celda = document.createElement("p");
                    var span = document.createElement("span"); // Create a <p> element
                    span.innerHTML =
                        '<span class="badge badge-pill badge-success p-1 m-1">Fecha: ' +
                        subTerminalValueObj.date_value + '</span><br><b>Observación:</b> ' +
                        subTerminalValueObj.description;
                    celda.appendChild(span);
                    li.appendChild(celda);

                    ul.appendChild(li);
                });
                tbl.appendChild(ul);
            });
            toastr.info("Tarifa de Equipos ha sido Actualizada")
        });

        var channel4 = pusher.subscribe('customer');
        channel4.bind('total-customer', function(data) {
            $(".customer").empty();
            $("#customer").append('<b>' + data.customer + '</b>');
            toastr.info("Se ha Actualizado el listado de Clientes")
        });

        var channel5 = pusher.subscribe('contract');
        channel5.bind('total-contract', function(data) {
            $(".contract").empty();
            $.each(data, function(index, subContractObj) {
                $.each(subContractObj, function(index, subContractIdObj) {
                    $('#contract-' + subContractIdObj.dashboard_status).empty();
                    $('#contract-' + subContractIdObj.dashboard_status).append('<b>' +
                        subContractIdObj.total + '</b>');
                });
            });
            toastr.info("Contrato Generado o Actualizado")
        });

        var channel6 = pusher.subscribe('invoice');
        channel6.bind('total-invoice', function(data) {
            $(".invoice").empty();
            $("#invoice").append('<b>' + data.invoice + '</b>');
            toastr.info("Conciliación Generada o Procesada")
        });

        var channel7 = pusher.subscribe('order');
        channel7.bind('total-order', function(data) {
            $.each(data, function(index, subOrderObj) {
                $.each(subOrderObj, function(index, subOrderIdObj) {
                    $("#order-" + subOrderIdObj.order_status).empty();
                    $("#order-" + subOrderIdObj.order_status).append(subOrderIdObj.total);
                });
            });
            toastr.info("Orden de Servicio Generada o Procesada")
        });
    </script>
@endsection

@section('main-content')
    <div class="breadcrumb">
        <h1>{{ $identity ?? 'Dashboard' }}</h1>

    </div>

    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <!-- ICON BG -->
        <div class="col-lg-7">
            <div class="card-body col-lg-7">
                <h5 class="mt-0 header-title"><b>Tarifa Divisa</b></h5>
            </div>
            <div class="col-lg-7">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Dollar"></i>
                        <div class="content">
                            <center>
                                <b>
                                    <div id="last" class="last currencyvalue" style="font-size:15px;"></div>
                                </b>
                                <span class="badge badge-pill badge-success p-1 m-1">Fecha: <span id="last_date"
                                        class="last_date currencyvalue"></span></span>
                                <span class="text-muted">Precio Dolár</span>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-lg-12 row">
            <div class="card-body">
                <h5 class="mt-0 header-title"><b>Precio Punto de Venta</b></h5>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden">
                <div class="card-body text-center">
                    <i class="i-Smartphone--Secure"></i>
                    <span>
                        <div id="terminalvalue_card" name="terminalvalue_card" class="terminalvalue"></div>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card-body col-lg-12">
                <h5 class="mt-0 header-title"><b>Ventas</b></h5>
            </div>
            <div class="col-lg-12">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Notepad"></i>
                        <div class="content">
                            <center>
                                <br>
                                <h5>
                                    <b><span id="preafiliation" name="preafiliation" class="preafiliation"
                                            style="font-size:15px;">0</span></b>
                                </h5>
                                <span>Preafiliados</span>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
        <div class="col-lg-6">
            <div class="card-body col-lg-12">
                <h5 class="mt-0 header-title"><b>Administración</b></h5>
            </div>

            <div class="col-lg-12">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Money-2"></i>
                        <div class="content">
                            <center>
                                <h5 class="mb-0">
                                    <b><span id="invoice" class="invoice" style="font-size:15px;">0</span></b>
                                </h5>
                                <span>En Conciliación</span>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    @can('dashboard.index')
        <div class="row">
            <div class="col-lg-12 row">
                <div class="card-body">
                    <h5 class="mt-0 header-title"><b>Clientes - Puntos de Venta</b></h5>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Business-Mens"></i>
                        <div class="content">
                            <center>
                                <h6 class="mb-0">
                                    <b><span id="customer" name="customer" class="customer"
                                            style="font-size:15px;">0</span></b>
                                </h6>
                                <p class="text-muted font-12">Total Clientes</p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Checkout"></i>
                        <div class="content">
                            <center>
                                <h6 class="mb-0">
                                    <b><span id="contract-CA" name="contract-CA" class="contract-CA"
                                            style="font-size:15px;">0</span></b>
                                </h6>
                                <p class="text-muted font-12">Activos</p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Full-Cart"></i>
                        <div class="content">
                            <center>
                                <h6 class="mb-0">
                                    <b><span id="contract-CP" name="contract-CP" class="contract-CP"
                                            style="font-size:15px;">0</span></b>
                                </h6>
                                <p class="text-muted font-12">Pendientes</p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Support"></i>
                        <div class="content">
                            <center>
                                <h6 class="mb-0">
                                    <div id="contract-CS" name="contract-CS" class="contract-CS" style="font-size:15px;">
                                        <b>0</b>
                                    </div>
                                </h6>
                                <p class="text-muted font-12">Servicio Técnico</p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Remove-Cart"></i>
                        <div class="content">
                            <center>
                                <h6 class="mb-0">
                                    <h6 class="mb-0">
                                        <div id="contract-CC" name="contract-CC" class="contract-CC"
                                            style="font-size:15px;">
                                            <b>0</b>
                                        </div>
                                    </h6>
                                </h6>
                                <p class="text-muted font-12">Cancelados</p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card-body col-lg-12">
                <h5 class="mt-0 header-title"><b>Operaciones</b></h5>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Gear"></i>
                        <div class="content">
                            <center>
                                <h5 class="mb-0">
                                    <b><span id="order-P" class="order-P">0</span></b>
                                </h5>
                                <p class="text-muted font-12">Programación Sin Gestión</p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Gears"></i>
                        <div class="content">
                            <center>
                                <h5 class="mb-0">
                                    <b><span id="order-PI" class="order-PI">0</span></b>
                                </h5>
                                <p class="text-muted font-12">Programación Inicial</p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="card-body col-lg-12">
                <h5 class="mt-0 header-title"><b>Facturación</b></h5>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Financial"></i>
                        <div class="content">
                            <center>
                                <h5 class="mb-0">
                                    <div id="order_CC" class="order"><b>0</b></div>
                                </h5>
                                <p class="text-muted font-12">Sin Facturar</p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Billing"></i>
                        <div class="content">
                            <center>
                                <h5 class="mb-0">
                                    <div id="order_CC" class="order"><b>0</b></div>
                                </h5>
                                <p class="text-muted font-12">Facturado</p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="row">
            <div class="card-body col-lg-12">
                <h5 class="mt-0 header-title"><b>Almacén</b></h5>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Box-Full"></i>
                        <div class="content">
                            <center>
                                <h5 class="mb-0">
                                    <b><span id="terminals-D" class="terminals-D">0</span></b>
                                </h5>
                                <p class="text-muted font-12">Equipos Disponibles</p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Mail-Send"></i>
                        <div class="content">
                            <center>
                                <h5 class="mb-0">
                                    <b><span id="order-S" class="order-S">0</span></b>
                                </h5>
                                <p class="text-muted font-12">Ordenes</p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Inbox-Out"></i>
                        <div class="content">
                            <center>
                                <h5 class="mb-0">
                                    <b><span id="order-D" class="order-D">0</span></b>
                                </h5>
                                <p class="text-muted font-12">Despacho</p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Mailbox-Full"></i>
                        <div class="content">
                            <center>
                                <h5 class="mb-0">
                                    <b><span id="order-C" class="order-C">0</span></b>
                                </h5>
                                <p class="text-muted font-12">Entregado Cliente</p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    @endcan
    <!-- Content-->
@endsection

@section('page-js')
    @toastr_js
    @toastr_render
    <script type="text/javascript">
        $(document).ready(function() {
            $.get('/preafiliations/getTotal', function(data) {
                $(".preafiliation").empty();
                $("#preafiliation").append(data);
            });

            $.get('/customers/totalCustomer', function(data) {
                $(".customer").empty();
                $("#customer").append(data);
            });

            $.get('/contracts/totalContract', function(data) {
                $.each(data, function(index, subContractObj) {
                    $("#contract-" + subContractObj.dashboard_status).empty();
                    $("#contract-" + subContractObj.dashboard_status).append(subContractObj.total);
                });
            });

            $.get('/invoices/totalInvoice', function(data) {
                $(".invoice").empty();
                $("#invoice").append(data);
            });

            $.get('/terminals/totalTerminals', function(data) {
                $.each(data, function(index, subTerminalsObj) {
                    $("#terminals-" + subTerminalsObj.terminal_status).empty();
                    $("#terminals-" + subTerminalsObj.terminal_status).append(subTerminalsObj
                        .total);
                });
            });

            $.get('/orders/totalStatus', function(data) {
                $.each(data, function(index, subOrderObj) {
                    $("#order-" + subOrderObj.order_status).empty();
                    $("#order-" + subOrderObj.order_status).append(subOrderObj.total);
                });
            });

            $.get('/currencyvalues/getLast', function(data) {
                $(".currencyvalue").empty();
                $("#last").append('Bs. ' + data.value);
                $("#last_date").append(data.date_value);
            });

            $.get('/terminalvalues/getLast', function(data) {
                var tbl = document.getElementById("terminalvalue_card");
                var ul = document.createElement("ul");
                ul.setAttribute("class", "list-inline widget-chart text-center");

                $.each(data, function(index, subTerminalValueObj) {
                    var li = document.createElement("li");
                    li.setAttribute("class", "list-inline-item p-4");

                    var celda = document.createElement("div");
                    var span = document.createElement("span"); // Create a <p> element
                    span.innerHTML = '<div class="currency_value"><b>' + subTerminalValueObj
                        .amount_currency + ' | ' + subTerminalValueObj.amount_local + '<b></div>';
                    celda.appendChild(span);
                    li.appendChild(celda);

                    var celda = document.createElement("div");
                    var span = document.createElement("span"); // Create a <p> element
                    span.innerHTML = '<b>' + subTerminalValueObj.modelTerminal + '</b><br>';
                    celda.appendChild(span);
                    li.appendChild(celda);

                    var celda = document.createElement("div");
                    var span = document.createElement("span"); // Create a <p> element
                    span.innerHTML =
                        '<span class="badge badge-pill badge-success p-1 m-1">Fecha: ' +
                        subTerminalValueObj.date_value +
                        '</span><br><span  ><b>Observación:</b></span> ' + subTerminalValueObj
                        .description;
                    celda.appendChild(span);
                    li.appendChild(celda);

                    li.appendChild(celda);
                    ul.appendChild(li);
                });
                tbl.appendChild(ul);
            });
        });
    </script>
@endsection
