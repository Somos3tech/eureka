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
                    <center>
                        <div class="btn-group p-4">
                            <a id="forecast" name="forecast" href="{{ route('services.report') }}"
                                class="btn btn-sm btn-dark">Descargar Reporte</a></li>
                        </div>
                    </center>

                    <div id="forecasts" style="display:block;" class="box-body table-responsive">
                        <table id="forecasts-table" class="table table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>ID Cobro</center>
                                    </th>
                                    <th>
                                        <center>Creado</center>
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
                                        <center>Serial Terminal</center>
                                    </th>
                                    <th>
                                        <center>No. Terminal</center>
                                    </th>
                                    <th>
                                        <center>Tipo Moneda</center>
                                    </th>
                                    <th>
                                        <center>Monto Cobro</center>
                                    </th>
                                    <th>
                                        <center>Tipo Cobro</center>
                                    </th>
                                    <th>
                                        <center>Referencia</center>
                                    </th>
                                    <th>
                                        <center>Frecuencia Cobro</center>
                                    </th>
                                    <th>
                                        <center>No. Cuenta</center>
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

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#forecasts').show();
            listforecast();
        });

        var listforecast = function() {
            table = $('#forecasts-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('services.datatable') }}",
                columns: [

                    {
                        data: "id",
                        "className": "text-center"
                    },
                    {
                        data: "fechpro",
                        "className": "text-center"
                    },
                    {
                        data: "rif",
                        "className": "text-center"
                    },
                    {
                        data: "business_name",
                        "className": "text-left"
                    },
                    {
                        data: "contract_id",
                        "className": "text-center"
                    },
                    {
                        data: "serial_terminal",
                        "className": "text-center"
                    },
                    {
                        data: "nropos",
                        "className": "text-center"
                    },
                    {
                        data: "currency",
                        "className": "text-center"
                    },
                    {
                        data: "amount",
                        "className": "text-center"
                    },
                    {
                        data: "tipnot",
                        "className": "text-center"
                    },
                    {
                        data: "refere",
                        "className": "text-center"
                    },
                    {
                        data: "frec_invoice",
                        "className": "text-center"
                    },
                    {
                        data: "nrocta",
                        "className": "text-center"
                    },
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                "order": [
                    [8, "asc"]
                ],
            });
        }
        /******************************************************************************/
    </script>
@endsection
