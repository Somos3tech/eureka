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
                    @can('mtypeitems.create')
                        <p>
                            <center><a class="btn btn-sm btn-info" href="#" data-toggle="modal"
                                    data-target="#mtypeitemsCreate" title="Registrar"><i class="ion-compose"></i> Registrar</a>
                            </center>
                        </p>
                    @endcan
                    <div id="mtypeitems" style="display:block;" class="box-body table-responsive">
                        <table id="mtypeitems-table" class="table table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Tipo Gestión</center>
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

@include('supports::mtypeitems.create')
@include('supports::mtypeitems.edit')
@include('supports::mtypeitems.delete')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $('#mtypeitems').show();
            listmtypeitems();
        });
        var listmtypeitems = function() {
            table = $('#mtypeitems-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/mtypeitems/datatable",
                columns: [{
                        data: "managementtype",
                        "className": "text-center",
                    },
                    {
                        data: "mtypeitem",
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

        $.get('/managementtypes/select', function(data) {
            $('.managementtype_id').empty();
            $('.managementtype_id').append("<option value=''>Seleccione Tipo Gestión...</option>");
            $.each(data, function(index, subManagementtypeObj) {
                $('.managementtype_id').append("<option value='" + subManagementtypeObj.id + "'>" +
                    subManagementtypeObj.description + "</option>");
            });
        });


        $("#create").click(function() {
            var managementtype_id = $("#managementtype_id").val();
            var description = $("#description").val();
            var route = "{{ route('mtypeitems.store') }}";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'post',
                dataType: 'json',
                data: {
                    managementtype_id: managementtype_id,
                    description: description
                },
                success: function(data) {
                    $("#mtypeitemsCreate").modal("hide");
                    $("#form-create")[0].reset();
                    $('#mtypeitems-table').DataTable().ajax.reload();
                    toastr.info("Se ha Registrado Correctamente")
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subMarkObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subMarkObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subMarkObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var mtypeitems = function(btn) {
            val = btn.value;
            var route = "{{ url('mtypeitems') }}/" + val + "/edit";
            $.get(route, function(res) {
                $("#id").val(res.id);
                $("#managementtype_id_up option[value=" + res.managementtype_id + "]").attr("selected", true);
                $("#description_up").val(res.description);

            })
        }
        $("#update").click(function() {
            var id = $("#id").val();
            var managementtype_id = $("#managementtype_id_up").val();
            var description = $("#description_up").val();
            var route = "{{ url('mtypeitems') }}/" + id;
            var token = $("#token").val();
            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'PUT',
                dataType: 'json',
                data: {
                    managementtype_id: managementtype_id,
                    description: description
                },

                success: function(data) {
                    $("#mtypeitemsUpdate").modal("hide");
                    $("#form-edit")[0].reset();
                    $('#mtypeitems-table').DataTable().ajax.reload();
                    toastr.info("Registro se ha Actualizado Correctamente")

                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subManagementtypeObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subManagementtypeObj[0] +
                                '</li>';
                        } else {
                            notification = '<li>' + subManagementtypeObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var mtypeitemsDelete = function(btn) {
            $("#id").val(btn.value);
        }

        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('mtypeitems') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#mtypeitemsDelete").modal("hide");
                    $('#mtypeitems-table').DataTable().ajax.reload();
                    toastr.info("Registro Eliminado Correctamente")
                },
                error: function(data) {
                    toastr.warning("Error al Eliminar Registro")
                }
            });
        });
    </script>
@endsection
