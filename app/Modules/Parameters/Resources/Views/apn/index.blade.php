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
                    @can('apn.create')
                        <p>
                            <center><a class="btn btn-sm btn-info" href="#" data-toggle="modal" data-target="#apnCreate"
                                    title="Registrar"><i class="ion-compose"></i> Registrar</a></center>
                        </p>
                    @endcan
                    <div id="apn" style="display:block;" class="box-body table-responsive">
                        <table id="apn-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Descripción</center>
                                    </th>
                                    <th>
                                        <center>Operador</center>
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

@include('parameters::apn.create')
@include('parameters::apn.edit')
@include('parameters::apn.delete')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $('#apn').show();
            listapn();
        });
        var listapn = function() {
            table = $('#apn-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/apn/datatable",
                columns: [{
                        data: "description",
                        "className": "text-center",
                    },
                    {
                        data: "operator",
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

        $.get('/operators/select', function(data) {
            $('.operator_id').empty();
            $('.operator_id').append("<option value=''>Seleccione Operador...</option>");
            $.each(data, function(index, subOperatorObj) {
                $('.operator_id').append("<option value='" + subOperatorObj.id + "'>" + subOperatorObj
                    .description + "</option>");
            });
        });

        $("#create").click(function() {
            var description = $("#description").val();
            var operator_id = $("#operator_id").val();
            var route = "{{ route('apn.store') }}";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'post',
                dataType: 'json',
                data: {
                    description: description,
                    operator_id: operator_id
                },
                success: function(data) {
                    $("#apnCreate").modal("hide");
                    $("#form-create")[0].reset();
                    $('#apn-table').DataTable().ajax.reload();
                    toastr.info("Se ha Registrado Correctamente")
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subApnkObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subApnkObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subApnkObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var apn = function(btn) {
            val = btn.value;
            var route = "{{ url('apn') }}/" + val + "/edit";
            $.get(route, function(res) {
                $("#id").val(res.id);
                $("#operator_up_id option[value=" + res.operator_id + "]").attr("selected", true);
                $("#description_up").val(res.description);
            })
        }
        $("#update").click(function() {
            var id = $("#id").val();
            var description = $("#description_up").val();
            var operator_id = $("#operator_up_id").val();
            var route = "{{ url('apn') }}/" + id;
            var token = $("#token").val();
            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'PUT',
                dataType: 'json',
                data: {
                    description: description,
                    operator_id: operator_id
                },

                success: function(data) {
                    $("#apnUpdate").modal("hide");
                    $("#form-edit")[0].reset();
                    $('#apn-table').DataTable().ajax.reload();
                    toastr.info("Registro se ha Actualizado Correctamente")

                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subApnkObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subApnkObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subApnkObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var apnDelete = function(btn) {
            $("#id").val(btn.value);
        }

        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('apn') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#apnDelete").modal("hide");
                    $('#apn-table').DataTable().ajax.reload();
                    toastr.info("Registro Eliminado Correctamente")
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subApnObj) {
                        if (notification != '') {
                            notification = notification + ' | ' + subApnObj[0];
                        } else {
                            notification = subApnObj[0];
                        }
                    });
                    toastr.error("Error al Eliminar Registro")
                }
            });
        });
    </script>
@endsection
