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
                        <div class="col-md-2">
                            <center>
                                <div class="btn-group btn-sm">
                                    <button type="button" class="btn btn-sm btn-warning"
                                        style="color:white;">Filtro(s)</button>
                                    <button type="button" class="btn btn-sm btn-warning dropdown-toggle"
                                        data-toggle="dropdown" style="color:white;">
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a id="dispatch" class="btn btn-sm btn-default filter">Despacho</a></li>
                                        <li><a id="customer" class="btn btn-sm btn-default filter">Entregado</a></li>
                                    </ul>
                                </div>
                            </center>
                        </div>
                        <div class="col-md-9">
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
                                        <center>Acción</center>
                                    </th>
                                    <th>
                                        <center>Status</center>
                                    </th>
                                    <th>
                                        <center>No. Orden</center>
                                    </th>
                                    <th>
                                        Creado
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
                                        S. terminal
                                    </th>
                                    <th>
                                        Operador
                                    </th>
                                    <th>
                                        Fecha Entrega
                                    </th>
                                    <th>
                                        Actualizado
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

@include('operations::orders.show')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $('#orders').show();
            listorder('D');
            table.columns(1).search('Despacho').draw();
        });
        var listorder = function(status) {
            table = $('#orders-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 50,
                ajax: "/orders/dataStatus?status=" + status + "&action=basic",
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
                        data: "created_order",
                        "className": "text-center",
                        "width": "10%"
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
                    // Alcides Da Silva - campo sterminal agregado para mostrar el serial del terminal en datatable
                    {
                        data: "sterminal",
                        "className": "text-center"
                    },
                    {
                        data: "operator",
                        "className": "text-center"
                    },
                    {
                        data: "posted",
                        "className": "text-center"
                    },
                    {
                        data: "updated_order",
                        "className": "text-center",
                        "width": "10%"
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
        $('#dispatch').on('click', function() {
            table.destroy();
            listorder('D');
        });

        $('#customer').on('click', function() {
            table.destroy();
            listorder('C');
        });

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
                $("#date_send").val(res.date_send);
                $("#observ_posted").val(res.observ_posted);
                $("#number_control").val(res.number_control);
                $("#type_posted").val(res.type_posted);
                $("#status_order").empty();
                $("#status_order").append(res.status_order);
            });
        }
    </script>
@endsection
