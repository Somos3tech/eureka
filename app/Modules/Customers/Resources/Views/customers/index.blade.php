@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/datatables.min.css') }}">
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
                    <div id="customers" style="display:block;" class="box-body table-responsive">
                        <table id="customers-table" class="table table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Código Cliente</center>
                                    </th>
                                    <th>
                                        <center>RIF</center>
                                    </th>
                                    <th>
                                        <center>Razón Social</center>
                                    </th>
                                    <th>
                                        <center>Equipos Activos</center>
                                    </th>
                                    <th>
                                        <center>Acción</center>
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
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $('#customers').show();
            listcustomer();
        });
        /**************************************************************************/
        var listcustomer = function() {
            var route = "/customers/datatable?string={{ $string }}";
            table = $('#customers-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: route,
                columns: [{
                        data: "id",
                        "className": "text-center",
                        "width": "12%"
                    },
                    {
                        data: "rif",
                        "className": "text-center",
                        "width": "12%"
                    },
                    {
                        data: "business_name",
                        "className": "text-left"
                    },
                    {
                        data: "tterm",
                        "className": "text-center",
                        "width": "3%"
                    },
                    {
                        data: "actions",
                        "width": "15%"
                    },
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: []
            });
        }
        /**************************************************************************/
        var CustomerDelete = function(btn) {
            $("#id").val(btn.value);
        }
        /**************************************************************************/
        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('customers') }}/" + id + "";

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#deleteCustomer").modal("hide");
                    var alert = document.getElementById('info');
                    document.getElementById("info").innerHTML = "";
                    $('<strong>' + data.message + '</strong>').prependTo('#info');
                    alert.style.display = 'block';
                    $("#info").fadeIn(1500);
                    $("#info").fadeOut(10000);
                    $('#customers-table').DataTable().ajax.reload();
                },
                error: function(data) {
                    $("#deleteCustomer").modal("hide");
                    var alert = document.getElementById('danger');
                    document.getElementById("danger").innerHTML = "";
                    $('<strong>' + data.message + '</strong>').prependTo('#danger');
                    alert.style.display = 'block';
                    $("#danger").fadeIn(1500);
                    $("#danger").fadeOut(10000);
                }
            });
        });
    </script>
@endsection
