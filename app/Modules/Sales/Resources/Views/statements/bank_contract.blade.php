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
        <div class="col-sm-12">
            <center>
                <div class="btn-group btn-sm">
                    <button type="button" class="btn btn-sm btn-dark" style="color:white;">Bancos</button>
                    <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-toggle="dropdown"
                        style="color:white;"></button>
                    <ul class="dropdown-menu" role="menu">
                        <div id="banks-button"></div>
                    </ul>
                </div>
            </center>
            <div id="statements" style="display:block;" class="box-body table-responsive">
                <table id="statements-table" name="statements-table" class="table table-striped table-bordered"
                    cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>
                                <center>Acción</center>
                            </th>
                            <th>
                                <center>RIF</center>
                            </th>
                            <th>
                                <center>Comercio</center>
                            </th>
                            <th>
                                <center>No. Contrato</center>
                            </th>
                            <th>
                                <center>Status Servicio</center>
                            </th>
                            <th>
                                <center>Plan Servicio</center>
                            </th>
                            <th>
                                <center>Serial Terminal</center>
                            </th>
                            <th>
                                <center>Banco</center>
                            </th>
                            <th>
                                <center>Balance</center>
                            </th>
                            <th>
                                <center>Cargos</center>
                            </th>
                            <th>
                                <center>Total Cargos ($)</center>
                            </th>
                            <th>
                                <center>Abonos</center>
                            </th>
                            <th>
                                <center>Total Abonos ($)</center>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- Content-->
@endsection

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>

    @toastr_js
    @toastr_render
    <script type="text/javascript">
        $(document).ready(function() {
            $('#statements').show();
            statements();
        });
        /**************************************************************************/
        var statements = function() {
            var route = "/statements/datatableBankContractCustomer";
            table = $('#statements-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 50,
                autoWidth: false,
                ajax: route,
                columns: [{
                        data: "actions",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "rif",
                        "className": "text-center",
                    },
                    {
                        data: "business_name",
                        "className": "text-left",
                    },
                    {
                        data: "contract_id",
                        "className": "text-center",
                    },
                    {
                        data: "status",
                        "className": "text-center",
                    },
                    {
                        data: "term_name",
                        "className": "text-center",
                    },
                    {
                        data: "terminal",
                        "className": "text-center",
                    },
                    {
                        data: "bank_name",
                        "className": "text-left",
                    },
                    {
                        data: "balance",
                        "className": "text-center"
                    },
                    {
                        data: "total_pending",
                        "className": "text-center"
                    },
                    {
                        data: "amount_pending",
                        "className": "text-center",
                    },
                    {
                        data: "total_collection",
                        "className": "text-center"
                    },
                    {
                        data: "amount_collection",
                        "className": "text-center"
                    },
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [],
                "order": []
            });
        }
        /************************************************************************/
        $.get('/banks/select', function(data) {
            $('#banks-button').empty();
            Object.keys(data).forEach(function(key) {
                $('<li><a id="' + key + '" class="btn btn-sm btn-default filter">' + data[key].description +
                    '</a></li>').prependTo('#banks-button');
                $('#' + key).on('click', function() {
                    table.search('').columns().search('').draw();
                    table.columns(7).search(data[key].description).draw();
                });
            });
        });
    </script>
@endsection
