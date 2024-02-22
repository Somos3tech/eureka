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
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    @can('zonerole.create')
                        <p>
                            <center><a id="zonerole-create" class="btn btn-sm btn-info" href="#" data-toggle="modal"
                                    data-target="#zonerolesCreate" title="Registrar"><i class="ion-compose"></i> Registrar</a>
                            </center>
                        </p>
                    @endcan
                    <div id="zoneroles" style="display:block;" class="box-body table-responsive">
                        <table id="zoneroles-table" class="table table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Perfil</center>
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

@include('parameters::zoneroles.create')
@include('parameters::zoneroles.edit')
@include('parameters::zoneroles.delete')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $('#zoneroles').show();
            listzoneroles();
        });
        var listzoneroles = function() {
            table = $('#zoneroles-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/zoneroles/datatable",
                columns: [{
                        data: "description",
                        "className": "text-center",
                    },
                    {
                        data: "actions"
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
            var role_id = $("#role_id").val();
            var route = "{{ route('zoneroles.store') }}";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'post',
                dataType: 'json',
                data: {
                    role_id: role_id,
                },
                success: function(data) {
                    $("#zonerolesCreate").modal("hide");
                    $("#form-create")[0].reset();
                    $('#zoneroles-table').DataTable().ajax.reload();
                    toastr.info("Se ha Registrado Correctamente")
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subZoneRoleObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subZoneRoleObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subZoneRoleObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var zonerole = function(btn) {
            val = btn.value;
            var route = "{{ url('zoneroles') }}/" + val + "/edit";
            $.get(route, function(res) {
                $("#id").val(res.id);
                $.get('/roles/select?action=zonerole', function(data) {
                    $('#role_id').empty();
                    $('#role_id_up').append("<option value=''>Seleccione Perfil...</option>");
                    $.each(data, function(index, subRoleObj) {
                        $('#role_id_up').append("<option value='" + subRoleObj.id + "'>" +
                            subRoleObj.description + "</option>");
                        $("#role_id_up option[value=" + res.role_id + "]").attr("selected",
                            true);
                    });
                });
            })
        }

        $("#update").click(function() {
            var id = $("#id").val();
            var role_id = $("#role_id_up").val();
            var route = "{{ url('zoneroles') }}/" + id;
            var token = $("#token").val();
            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'PUT',
                dataType: 'json',
                data: {
                    role_id: role_id,
                },

                success: function(data) {
                    $("#zoneroleUpdate").modal("hide");
                    $("#form-edit")[0].reset();
                    $('#zoneroles-table').DataTable().ajax.reload();
                    toastr.info("Registro se ha Actualizado Correctamente")

                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subZoneRoleObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subZoneRoleObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subZoneRoleObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var zoneroleDelete = function(btn) {
            $("#id").val(btn.value);
        }

        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('zoneroles') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#zoneroleDelete").modal("hide");
                    $('#zoneroles-table').DataTable().ajax.reload();
                    toastr.info("Registro Eliminado Correctamente")
                },
                error: function(data) {
                    toastr.warning("Error al Eliminar Registro")
                }
            });
        });
        $("#zonerole-create").click(function() {
            $.get('/roles/select?action=zonerole', function(data) {
                $('#role_id').empty();
                $('#role_id').append("<option value=''>Seleccione Perfil...</option>");

                $.each(data, function(index, subRoleObj) {
                    $('#role_id').append("<option value='" + subRoleObj.id + "'>" + subRoleObj
                        .description + "</option>");
                });
            });
        });
    </script>
@endsection
