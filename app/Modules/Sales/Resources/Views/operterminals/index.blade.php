@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/datatables.min.css') }}">
    <style>
        th,
        td {
            font-size: 13px;
        }

        .btn {
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
                    <center>
                        <div class="btn-group btn-sm">
                            <button type="button" class="btn btn-sm btn-dark" style="color:white;">Gestión</button>
                            <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-toggle="dropdown"
                                style="color:white;"></button>
                            <ul class="dropdown-menu" role="menu">
                                @can('operterminals.create')
                                    <li><a class="btn btn-sm  btn-default filter" style=" color: #47404f;"
                                            href="{{ route('operterminals.create') }}">Registrar</a></li>
                                @endcan
                                <li><a id="pending" class="btn btn-sm  btn-default filter">Pendientes</a></li>
                                <li><a id="finish" class="btn btn-sm btn-default filter">Finalizados</a></li>
                                <li><a id="canceled" class="btn btn-sm  btn-default filter">Anulados</a></li>
                            </ul>
                        </div>
                    </center>
                    <div id="operterminals" style="display:block;" class="box-body table-responsive">
                        <table id="operterminals-table" class="table table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Acción</center>
                                    </th>
                                    <th>
                                        <center>No. Gestion</center>
                                    </th>
                                    <th>
                                        <center>Creado</center>
                                    </th>
                                    <th>
                                        <center>Status</center>
                                    </th>
                                    <th>
                                        <center>RIF</center>
                                    </th>
                                    <th>
                                        <center>Comercio</center>
                                    </th>
                                    <th>
                                        <center>Serial Equipo</center>
                                    </th>
                                    <th>
                                        <center>Tipo Operación</center>
                                    </th>

                                    <th>
                                        <center>Suspensión</center>
                                    </th>
                                    <th>
                                        <center>Reactivación</center>
                                    </th>
                                    <th>
                                        <center>Creado Por</center>
                                    </th>
                                    <th>
                                        <center>Actualizado</center>
                                    </th>
                                    <th>
                                        <center>Actualizado Por</center>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content-->
@endsection

@include('sales::operterminals.show')
@include('sales::operterminals.reactive')
@include('sales::operterminals.delete')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>

    @toastr_js
    @toastr_render

    <script type="text/javascript">
        $(document).ready(function() {
            operterminals('Pendiente');
        });
        /************************************************************************/
        var operterminals = function(status) {
            table = $('#operterminals-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 50,
                ajax: "/operterminals/datatable?status=" + status,
                columns: [{
                        data: "actions",
                        "className": "text-center"
                    },
                    {
                        data: "operterminal_id",
                        "className": "text-center"
                    },
                    {
                        data: "fechpro",
                        "className": "text-center"
                    },
                    {
                        data: "status",
                        "className": "text-left"
                    },
                    {
                        data: "rif",
                        "className": "text-center"
                    },
                    {
                        data: "business_name",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "terminal_serial",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "type_operation",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "date_inactive",
                        "className": "text-left"
                    },
                    {
                        data: "date_reactive",
                        "className": "text-left"
                    },
                    {
                        data: "name",
                        "className": "text-center"
                    },
                    {
                        data: "updated",
                        "className": "text-center"
                    },
                    {
                        data: "updated_name",
                        "className": "text-center"
                    }
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
        /************************************************************************/
        var OperTerminalId = function(btn) {
            var val = btn.value;
            var route = "/operterminals/" + val;

            $.get(route, function(data) {
                $(".operterminals_view").empty();
                $("#id_view").append(data.operterminal_id);
                $("#contract_view").append(data.contract_id);
                $("#business_name_view").append(data.business_name);
                $("#rif_view").append(data.rif);
                $("#fechpro_view").append(data.fechpro);
                $("#created_name_view").append(data.created_name);
                $("#type_operation_view").append(data.type_operation_name);
                if (data.type_service != null) {
                    $("#type_service_view").append(data.type_service);
                } else {
                    $("#type_service_view").append('----');
                }
                if (data.type_operation == "cambio") {
                    $(".term").attr("style", "display:block;");
                    $("#term_view").append(data.term);
                    $("#term_description_view").append(data.term_description);
                } else {
                    $(".term").attr("style", "display:none");
                }
                $("#inactive_view").append(data.date_inactive);
                $("#reactive_view").append(data.date_reactive);

                $("#observation_view").append(data.observations);
                $("#status_view").append(data.status);

                $("#updated_view").append(data.updated);
                $("#updated_name_view").append(data.updated_name);
            });
        }
        /************************************************************************/
        $('#canceled').on('click', function() {
            table.destroy();
            operterminals('Anulado');
        });
        /************************************************************************/
        $('#pending').on('click', function() {
            table.destroy();
            operterminals('Pendiente');
        });
        /************************************************************************/
        $('#finish').on('click', function() {
            table.destroy();
            operterminals('Finalizado');
        });
        /************************************************************************/
        var OperTerminalDelete = function(btn) {
            $("#id").val(btn.value);
        }
        /************************************************************************/
        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('operterminals') }}/" + id + "";

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#OperTerminalsDelete").modal("hide");
                    $('#operterminals-table').DataTable().ajax.reload();
                    toastr.info("Registro Eliminado Correctamente")
                },
                error: function(data) {
                    $("#OperTerminalsDelete").modal("hide");
                    toastr.warning("Error al Eliminar Registro")
                }
            });
        });
        /************************************************************************/
        var OperTerminalReactive = function(btn) {
            $("#reactive_id").val(btn.value);
        }
        /************************************************************************/
        $("#reactive").click(function() {
            var id = $("#reactive_id").val();
            var route = "{{ url('operterminals') }}/reactive/" + id + "";

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    $("#OperTerminalsReactiveView").modal("hide");
                    $('#operterminals-table').DataTable().ajax.reload();
                    toastr.info(data.message);
                },
                error: function(data) {
                    $("#OperTerminalsReactiveView").modal("hide");
                    toastr.warning("Error al Procesar la Gestión")
                }
            });
        });
    </script>
@endsection
