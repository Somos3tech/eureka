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
                    @can('operators.create')
                        <p>
                            <center><a class="btn btn-sm btn-info" href="#" data-toggle="modal"
                                    data-target="#operatorsCreate" title="Registrar"><i class="ion-compose"></i> Registrar</a>
                            </center>
                        </p>
                    @endcan
                    <div id="operators" style="display:block;" class="box-body table-responsive">
                        <table id="operators-table" class="table table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Descripción</center>
                                    </th>
                                    <th>
                                        <center>Simcard Incluida</center>
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

@include('parameters::operators.create')
@include('parameters::operators.edit')
@include('parameters::operators.delete')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>

    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $('#operators').show();
            listoperators();
        });
        /**************************************************************************/
        var listoperators = function() {
            table = $('#operators-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/operators/datatable",
                columns: [{
                        data: "description",
                        "className": "text-center",
                    },
                    {
                        data: "simcard",
                        "className": "text-center"
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
        /**************************************************************************/
        $("#create").click(function() {
            if (document.getElementById("is_simcard").checked) {
                document.getElementById("is_simcard").value = 'on';
            } else {
                document.getElementById("is_simcard").value = '';
            }
            var description = $("#description").val();
            var is_simcard = $("#is_simcard").val();
            var route = "{{ route('operators.store') }}";
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
                    is_simcard: is_simcard
                },
                success: function(data) {
                    $("#operatorsCreate").modal("hide");
                    $("#form-create")[0].reset();
                    $('#operators-table').DataTable().ajax.reload();
                    toastr.info("Se ha Registrado Correctamente")
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subOperatorObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subOperatorObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subOperatorObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });
        /**************************************************************************/
        var operators = function(btn) {
            val = btn.value;
            var route = "{{ url('operators') }}/" + val + "/edit";
            $.get(route, function(res) {
                $("#id").val(res.id);
                $("#description_up").val(res.description);
                if (res.is_simcard == 1) {
                    document.getElementById("is_simcard_up").checked = true;
                } else {
                    document.getElementById("is_simcard_up").checked = false;
                }
            })
        }
        /**************************************************************************/
        $("#update").click(function() {
            if (document.getElementById("is_simcard_up").checked) {
                document.getElementById("is_simcard_up").value = 'on';
            } else {
                document.getElementById("is_simcard_up").value = '';
            }
            var id = $("#id").val();
            var description = $("#description_up").val();
            var is_simcard = $("#is_simcard_up").val();
            var route = "{{ url('operators') }}/" + id;
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
                    is_simcard: is_simcard
                },

                success: function(data) {
                    $("#operatorsUpdate").modal("hide");
                    $("#form-edit")[0].reset();
                    $('#operators-table').DataTable().ajax.reload();
                    toastr.info("Registro se ha Actualizado Correctamente")

                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subOperatorObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subOperatorObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subOperatorObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });
        /**************************************************************************/
        var operatorsDelete = function(btn) {
            $("#id").val(btn.value);
        }
        /**************************************************************************/
        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('operators') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#operatorsDelete").modal("hide");
                    $('#operators-table').DataTable().ajax.reload();
                    toastr.info("Registro Eliminado Correctamente")
                },
                error: function(data) {
                    toastr.warning("Error al Eliminar Registro")
                }
            });
        });
    </script>
@endsection
