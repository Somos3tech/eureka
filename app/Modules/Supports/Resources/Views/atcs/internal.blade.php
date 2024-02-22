@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/datatables.min.css') }}">
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="col-md-12">
                                        <center>
                                            <div class="btn-group btn-sm" align="center">
                                                <button type="button" class="btn btn-sm btn-dark"
                                                    style="color:white;">Gestión</button>
                                                <button type="button" class="btn btn-sm btn-dark dropdown-toggle"
                                                    data-toggle="dropdown" style="color:white;"></button>
                                                <ul class="dropdown-menu" role="menu">
                                                    @can('atcs.create')
                                                        <li><a class="btn btn-sm  btn-default filter" style=" color: #47404f;"
                                                                href="{{ route('atcs.create') }}">Crear Ticket</a></li>
                                                    @endcan
                                                    <li><a id="create"
                                                            class="btn btn-sm  btn-default filter">Generados</a></li>
                                                    <li><a id="pending" class="btn btn-sm  btn-default filter">En
                                                            Proceso</a></li>
                                                    <li><a id="finish"
                                                            class="btn btn-sm btn-default filter">Procesados</a></li>
                                                    <li><a id="canceled"
                                                            class="btn btn-sm  btn-default filter">Anulados</a></li>
                                                    <li><a id="all" class="btn btn-sm  btn-default filter">Todos</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </center>
                                        <br>
                                    </div>

                                    <div class="col-md-12">
                                        <div id="atcs" style="display:block;" class="box-body table-responsive">
                                            <table id="atcs-table" class="table table-striped table-bordered"
                                                cellspacing="0" width="100%">
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
                                                            <center>Usuario</center>
                                                        </th>
                                                        <th>
                                                            <center>Canal Solicitud</center>
                                                        </th>
                                                        <th>
                                                            <center>Tipo Operación</center>
                                                        </th>
                                                        <th>
                                                            <center>Status</center>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content-->
@endsection

@include('supports::atcs.edit')
@include('supports::atcs.delete')
@include('supports::atcs.management')
@include('supports::atcs.show')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#atcs').show();
            atcs('', 'internal');
        });

        var atcs = function(status, managementtypes) {
            table = $('#atcs-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 50,
                ajax: "/atcs/datatable?status=" + status + "&slug=" + managementtypes,
                columns: [{
                        data: "actions",
                        "className": "text-center"
                    },
                    {
                        data: "id",
                        "className": "text-center"
                    },
                    {
                        data: "created",
                        "className": "text-center"
                    },
                    {
                        data: "name",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "channel",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "managementtype",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "status",
                        "className": "text-center"
                    },
                    {
                        data: "created_name",
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
        /****************************************************************************/
        $('#create').on('click', function() {
            table.destroy();
            atcs('G', 'internal');
        });
        /****************************************************************************/
        $('#pending').on('click', function() {
            table.destroy();
            atcs('P', 'internal');
        });
        /****************************************************************************/
        $('#finish').on('click', function() {
            table.destroy();
            atcs('F', 'internal');
        });
        /****************************************************************************/
        $('#canceled').on('click', function() {
            table.destroy();
            atcs('X', 'internal');
        });
        /****************************************************************************/
        $('#all').on('click', function() {
            table.destroy();
            atcs('', 'internal');
        });
    </script>
    @include('supports::atcs.js')
@endsection
