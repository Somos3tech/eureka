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
                    @can('channels.create')
                        <p>
                            <center><a class="btn btn-sm btn-info" href="#" data-toggle="modal"
                                    data-target="#channelsCreate" title="Registrar"><i class="ion-compose"></i> Registrar</a>
                            </center>
                        </p>
                    @endcan
                    <div id="channels" style="display:block;" class="box-body table-responsive">
                        <table id="channels-table" class="table table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Descripción</center>
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

@include('supports::channels.create')
@include('supports::channels.edit')
@include('supports::channels.delete')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $('#channels').show();
            listmanagementtype();
        });
        var listmanagementtype = function() {
            table = $('#channels-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/channels/datatable",
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
            var description = $("#description").val();
            var route = "{{ route('channels.store') }}";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'post',
                dataType: 'json',
                data: {
                    description: description
                },
                success: function(data) {
                    $("#channelsCreate").modal("hide");
                    $("#form-create")[0].reset();
                    $('#channels-table').DataTable().ajax.reload();
                    toastr.info("Se ha Registrado Correctamente")
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subchannelsObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subchannelsObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subchannelsObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var channels = function(btn) {
            val = btn.value;
            var route = "{{ url('channels') }}/" + val + "/edit";
            $.get(route, function(res) {
                $("#id").val(res.id);
                $("#description_up").val(res.description);
            })
        }
        $("#update").click(function() {
            var id = $("#id").val();
            var description = $("#description_up").val();
            var route = "{{ url('channels') }}/" + id;
            var token = $("#token").val();
            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'PUT',
                dataType: 'json',
                data: {
                    description: description
                },

                success: function(data) {
                    $("#channelsUpdate").modal("hide");
                    $("#form-edit")[0].reset();
                    $('#channels-table').DataTable().ajax.reload();
                    toastr.info("Registro se ha Actualizado Correctamente")

                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subchannelsObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subchannelsObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subchannelsObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var channelsDelete = function(btn) {
            $("#id").val(btn.value);
        }

        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('channels') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#channelsDelete").modal("hide");
                    $('#channels-table').DataTable().ajax.reload();
                    toastr.info("Registro Eliminado Correctamente")
                },
                error: function(data) {
                    toastr.warning("Error al Eliminar Registro")
                }
            });
        });
    </script>
@endsection
