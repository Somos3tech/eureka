@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/datatables.min.css') }}">
    @toastr_css
    <style>
        th,
        td {
            font-size: 12px;
        }

        .btn {
            border: none;
        }

        .outlinenone {
            outline: none;
            background-color: #dfe;
            border: 0;
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
                    <div class="col-md-12 row">
                        <div class="col-md-3">
                            <center>
                                @can('orders.edit')
                                    <div class="btn-group btn-sm">
                                        <button type="button" class="btn btn-sm btn-dark">Reporte</button>
                                        <button type="button" class="btn btn-sm btn-dark dropdown-toggle"
                                            data-toggle="dropdown"></button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a id="create" class="btn btn-sm btn-default"
                                                    href="{{ route('orders.report.programmer') }}" style="color:black;"> Reporte
                                                    Detallado</a></li>
                                            <li><a id="assign" class="btn btn-sm btn-default"
                                                    href="{{ route('orders.report.credicard') }}" style="color:black;"> Reporte
                                                    Credicard</a></li>
                                            <li><a id="assign" class="btn btn-sm btn-default"
                                                    href="{{ route('orders.report.platco') }}" style="color:black;"> Reporte
                                                    Platco</a></li>
                                        </ul>
                                    </div>
                                @endcan
                            </center>
                        </div>

                        <div class="col-md-8">
                            &nbsp;
                        </div>

                        <div class="col-md-1">
                            <div class="btn-group pull-right" align="left">
                                <a id="reset" class="btn btn-sm btn-warning" style="color: white;" title="Actualizar"><i
                                        class="fa fa-rotate-left"></i> Actualizar</a>
                            </div>
                        </div>
                    </div>
                    <div id="orders" style="display:block;" class="box-body table-responsive">
                        <table id="orders-table" class="table table-striped table-bordered table-responsive" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Acciones</center>
                                    </th>
                                    <th>
                                        <center>Status</center>
                                    </th>
                                    <th>
                                        <center>No. Orden</center>
                                    </th>
                                    <th>
                                        <center>RIF</center>
                                    </th>
                                    <th>
                                        <center>Comercio</center>
                                    </th>
                                    <th>
                                        <center>Almacén</center>
                                    </th>
                                    <th>
                                        <center>Banco</center>
                                    </th>
                                    <th>
                                        <center>Afiliado</center>
                                    </th>
                                    <th>
                                        Modelo
                                    </th>
                                    <th>
                                        Serial
                                    </th>
                                    <th>
                                        Operador
                                    </th>
                                    <th>
                                        Gestión
                                    </th>
                                    <th>
                                        Credicard
                                    </th>
                                    <th>
                                        Creado
                                    </th>
                                    <th>
                                        Actualizado
                                    </th>
                                    <th>
                                        Credicard
                                    </th>
                                    <th>
                                        Restaurar Gestión
                                    </th>
                                    <th>
                                        Soporte Ajustes
                                    </th>
                                </tr>
                            </thead>
                        </table>
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
@include('operations::orders.modals.check')
@include('operations::orders.modals.uncheck')
@include('operations::orders.show')
@include('operations::orders.modals.restore')
@include('operations::orders.modals.csupport')
@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $('#orders').show();
            listorder();
            setInterval('$("#orders-table").dataTable().fnDraw()', 60000);
        });
        /**************************************************************************/
        var listorder = function() {
            table = $('#orders-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 50,
                ajax: "/orders/dataStatus?status=P&action=basic",
                columns: [{
                        data: "actions",
                        "className": "text-center"
                    },
                    {
                        data: "status_order",
                        "className": "text-center"
                    },
                    {
                        data: "id",
                        "className": "text-center"
                    },
                    {
                        data: "rif",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "business_name",
                        "className": "text-left"
                    },
                    {
                        data: "company",
                        "className": "text-center"
                    },
                    {
                        data: "bank",
                        "className": "text-center"
                    },
                    {
                        data: "affiliate_number",
                        "className": "text-center"
                    },
                    {
                        data: "modelterminal",
                        "className": "text-center"
                    },
                    {
                        data: "terminal",
                        "className": "text-center"
                    },
                    {
                        data: "operator",
                        "className": "text-center"
                    },
                    {
                        data: "management",
                        "className": "text-center"
                    },
                    {
                        data: "credicard",
                        "className": "text-center"
                    },
                    {
                        data: "created_order",
                        "className": "text-center"
                    },
                    {
                        data: "updated_order",
                        "className": "text-center"
                    },
                    {
                        data: "check_credicard",
                        "className": "text-center"
                    },
                    {
                        data: "restore",
                        "className": "text-center"
                    },
                    {
                        data: "csupport",
                        "className": "text-center"
                    },
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [],
                "order": [
                    [2, "asc"]
                ]
            });
        }
        /**************************************************************************/
        $('#reset').on('click', function() {
            $('#orders-table').DataTable().ajax.reload();
        });
        /************************Ver Información Servicio**************************/
        var OrderShow = function(btn) {
            val = btn.value;
            var route = "{{ url('orders') }}/" + val;

            $.get(route, function(res) {
                $("#customer_id").val(res.customer_id);
                $("#rif").val(res.rif);
                $("#business_name").val(res.business_name);
                $("#state").val(res.state);
                $("#city").val(res.city);
                $("#address").val(res.address);
                $("#postal_code").val(res.postal_code);
                $("#email").val(res.email);
                $("#telephone").val(res.telephone);
                $("#mobile").val(res.mobile);
                /******************************Contrato********************************/
                $("#contract_id").val(res.contract_id);
                $("#created_contract").val(res.created_contract);
                $("#user_name").val(res.user_name);
                $("#consultant_name").val(res.consultant_name);
                $("#bank").val(res.bank);
                $("#affiliate_number").val(res.affiliate_number);
                $("#term").val(res.term);
                $("#observation_contract").val(res.observation_contract);
                $("#amount_contract").val(res.amount_contract);
                $("#posted_at").val(res.posted);
                $("#user_posted").val(res.user_posted);
                $("#status_contract").val(res.status_contract);
                /*******************************Orden**********************************/
                $("#order_id").val(res.id);
                $("#created_order").val(res.created_order);
                $("#user_created_order").val(res.user_created_order);
                $("#programmer_finish").val(res.programmer_finish);
                $("#company").val(res.company);
                $("#modelterminal").val(res.modelterminal);
                $("#terminal").val(res.terminal);
                $("#nropos").val(res.nropos);
                $("#operator").val(res.operator);
                $("#simcard").val(res.simcard);
                $("#programmer_at").val(res.programmer);
                $("#user_programmer").val(res.user_programmer);
                $("#observ_credicard").val(res.observ_credicard);
                $("#observ_programmer").val(res.observ_programmer);
                $("#status_order").empty();
                $("#status_order").append(res.status_order);
            });
        }
        /*******************Validar Envio Parametros Credicard*********************/
        var Ordercheck = function(btn) {
            $("#id_check").val(btn.value);
        }
        /**************************************************************************/
        $("#check").click(function() {
            var id = $("#id_check").val();
            var type_service = 'Check';
            var route = "/orders/service/" + id;
            var token = $("#token").val();
            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'PUT',
                dataType: 'json',
                data: {
                    type_service: type_service
                },
                success: function(data) {
                    $("#checkOrder").modal("hide");
                    $('#orders-table').DataTable().ajax.reload();
                    toastr.info("Notificación de Parametros a Credicard procesada Correctamente")
                },
                error: function(data) {
                    $("#checkOrder").modal("hide");
                    toastr.error(data.message)
                }
            });
        });
        /**************************************************************************/
        var Orderuncheck = function(btn) {
            $("#id_uncheck").val(btn.value);
        }
        /**************************************************************************/
        $("#uncheck").click(function() {
            var id = $("#id_uncheck").val();
            var type_service = 'Uncheck';
            var route = "/orders/service/" + id;
            var token = $("#token").val();
            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'PUT',
                dataType: 'json',
                data: {
                    type_service: type_service
                },
                success: function(data) {
                    $("#uncheckOrder").modal("hide");
                    $('#orders-table').DataTable().ajax.reload();
                    toastr.info("Notificación de Parametros a Credicard Cancelada")
                },
                error: function(data) {
                    $("#uncheckOrder").modal("hide");
                    toastr.error(data.message)
                }
            });
        });

        var managementRestore = function(btn) {
            var arrayValue = btn.value;
            var value = arrayValue.split("|");
            $("#order_id").val(value[0]);
            $("#contract_id").val(value[1]);
        }

        $("#restore").click(function() {
            var id = $("#order_id").val();
            var contract_id = $("#contract_id").val();
            var type_support = $("#type_support").val();
            var type_service = $("#type_service").val();
            var route = "/orders/service/restore/" + id;
            var token = $("#token").val();
            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'PUT',
                dataType: 'json',
                data: {
                    contract_id: contract_id,
                    type_support: type_support,
                    type_service: type_service
                },
                success: function(data) {
                    $("#restoreManagement").modal("hide");
                    document.getElementById("form-restore").reset();
                    $('#orders-table').DataTable().ajax.reload();
                    toastr.info("Gestión de restauración de Orden de Servicio procesada Correctamente")
                },
                error: function(data) {
                    $("#restoreManagement").modal("hide");
                    toastr.error(data.message)
                }
            });
        });

        var managementCsupport = function(btn) {
            var arrayValue = btn.value;
            var value = arrayValue.split("|");
            $("#order_id").val(value[0]);
            $("#contract_id").val(value[1]);
            $("#user").val(value[2]);
            $("#observation_request").val(value[3]);
        }

        $("#csupport").click(function() {
            var id = $("#order_id").val();
            var contract_id = $("#contract_id").val();
            var type_service = $("#service_csupport").val();
            var observation_response = $("#observation_response").val();
            var route = "/orders/service/csupport/" + id;
            var token = $("#token").val();
            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'PUT',
                dataType: 'json',
                data: {
                    contract_id: contract_id,
                    type_service: type_service,
                    observation_response: observation_response,
                },
                success: function(data) {
                    $("#csupportManagement").modal("hide");
                    document.getElementById("form-csupport").reset();
                    $('#orders-table').DataTable().ajax.reload();
                    toastr.info(data.message)
                },
                error: function(data) {
                    $("#csupportManagement").modal("hide");
                    toastr.error(data.message)
                }
            });
        });
    </script>

    </script>
@endsection
