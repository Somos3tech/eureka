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
    @toastr_css
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
                        <div class="btn-group">

                            <a id="reset" class="btn btn-sm btn-warning reset" style="color: white;"
                                title="Actualizar"><i class="fa fa-rotate-left"></i> Actualizar</a>
                        </div>
                    </center>
                    <hr>
                    <div id="billings" style="display:block;" class="box-body table-responsive">
                        <table id="billings-table" class="table table-striped table-bordered table-responsive"
                            cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Acción</center>
                                    </th>
                                    <th>
                                        <center>No. Factura</center>
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
                                        <center>Base Imponible</center>
                                    </th>
                                    <th>
                                        <center>Descuento</center>
                                    </th>
                                    <th>
                                        <center>Base Imponible (Desc.)</center>
                                    </th>
                                    <th>
                                        <center>IVA</center>
                                    </th>
                                    <th>
                                        <center>Total</center>
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

@include('operations::billings.delete');

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>

    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $('#billings').show();
            listbilling();
        });
        /****************************************************************************/
        var listbilling = function() {
            table = $('#billings-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 50,
                ajax: "/billings/datatable",
                columns: [{
                        data: "actions",
                        "className": "text-center"
                    },
                    {
                        data: "id",
                        "className": "text-center"
                    },
                    {
                        data: "fechpro",
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
                        data: "base",
                        "className": "text-center"
                    },
                    {
                        data: "free",
                        "className": "text-center"
                    },
                    {
                        data: "base_free",
                        "className": "text-center"
                    },
                    {
                        data: "iva",
                        "className": "text-center"
                    },
                    {
                        data: "total",
                        "className": "text-center"
                    },
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [],
                "order": [
                    [0, "desc"]
                ]
            });
        }
        /****************************************************************************/
        $('.reset').on('click', function() {
            $('#billings-table').DataTable().ajax.reload();
        });
        /****************************************************************************/
        var showBilling = function(btn) {
            var id = btn.value;
            window.open("/billings/pdf?id=" + id + "&template=Y", 'nuevaVentana', 'width=800, height=400')
        }
        /****************************************************************************/
        var showBillingN = function(btn) {
            var id = btn.value;
            myWindow = window.open("/billings/pdf?id=" + id + "&template=N", 'nuevaVentana', 'width=800, height=400');
            myWindow.focus();
            myWindow.print();
        }
        /****************************************************************************/
        var BillingDelete = function(btn) {
            $("#id").val(btn.value);
        }
        /****************************************************************************/
        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('billings') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#deleteBilling").modal("hide");
                    var alert = document.getElementById('info');
                    document.getElementById("info").innerHTML = "";
                    $('<strong>' + data.message + '</strong>').prependTo('#info');
                    alert.style.display = 'block';
                    $("#info").fadeIn(1500);
                    $("#info").fadeOut(5000);
                    $('#billings-table').DataTable().ajax.reload();
                },
                error: function(data) {
                    $("#deleteBilling").modal("hide");
                    var alert = document.getElementById('danger');
                    document.getElementById("danger").innerHTML = "";
                    $('<strong>' + data.message + '</strong>').prependTo('#danger');
                    alert.style.display = 'block';
                    $("#danger").fadeIn(1500);
                    $("#danger").fadeOut(5000);
                }
            });
        });
    </script>
@endsection
