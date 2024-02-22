@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/datatables.min.css') }}">
    @toastr_css
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
        <div class="col-md-10">
            <div class="card mb-4">
                <div class="card-body">
                    @can('cactivities.create')
                        <p>
                            <center><a class="btn btn-sm btn-info" href="#" data-toggle="modal"
                                    data-target="#cactivitiesCreate" title="Registrar"><i class="ion-compose"></i> Registrar</a>
                            </center>
                        </p>
                    @endcan
                    <div id="cactivities" style="display:block;" class="box-body table-responsive">
                        <table id="cactivities-table" class="table table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Código</center>
                                    </th>
                                    <th>
                                        <center>Descripción</center>
                                    </th>
                                    <th>
                                        <center>Acciones</center>
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

@include('parameters::cactivities.create')
@include('parameters::cactivities.edit')
@include('parameters::cactivities.delete')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $('#cactivities').show();
            listcactivities();
        });
        var listcactivities = function() {
            table = $('#cactivities-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/cactivities/datatable",
                columns: [{
                        data: "code_cactivity",

                    },
                    {
                        data: "description",

                    },
                    {
                        data: "actions",
                        "className": "text-center"
                    },
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: []
            });
        }

        $("#create").click(function() {
            var code_cactivity = $("#code_cactivity").val();
            var description = $("#description").val();
            var route = "{{ route('cactivities.store') }}";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'post',
                dataType: 'json',
                data: {
                    code_cactivity: code_cactivity,
                    description: description
                },
                success: function(data) {
                    $("#cactivitiesCreate").modal("hide");
                    $("#form-create")[0].reset();
                    $('#cactivities-table').DataTable().ajax.reload();
                    toastr.info("Se ha Registrado Correctamente")
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subCactiviyObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subCactiviyObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subCactiviyObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var cactivities = function(btn) {
            val = btn.value;
            var route = "{{ url('cactivities') }}/" + val + "/edit";
            $.get(route, function(res) {
                $("#id").val(res.id);
                $("#code_cactivity_up").val(res.code_cactivity);
                $("#description_up").val(res.description);
            })
        }
        $("#update").click(function() {
            var id = $("#id").val();
            var description = $("#description_up").val();
            var code_cactivity = $("#code_cactivity_up").val();
            var route = "{{ url('cactivities') }}/" + id;
            var token = $("#token").val();
            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'PUT',
                dataType: 'json',
                data: {
                    code_cactivity: code_cactivity,
                    description: description
                },

                success: function(data) {
                    $("#cactivitiesUpdate").modal("hide");
                    $("#form-edit")[0].reset();
                    $('#cactivities-table').DataTable().ajax.reload();
                    toastr.info("Registro se ha Actualizado Correctamente")

                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subCactiviyObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subCactiviyObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subCactiviyObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var cactivitiesDelete = function(btn) {
            $("#id").val(btn.value);
        }

        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('cactivities') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#cactivitiesDelete").modal("hide");
                    $('#cactivities-table').DataTable().ajax.reload();
                    toastr.info("Registro Eliminado Correctamente")
                },
                error: function(data) {
                    toastr.warning("Error al Eliminar Registro")
                }
            });
        });
    </script>
@endsection
