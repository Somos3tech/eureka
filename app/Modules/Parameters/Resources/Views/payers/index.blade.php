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
                    @can('payers.create')
                        <p>
                            <center><a class="btn btn-sm btn-info" href="#" data-toggle="modal" data-target="#payersCreate"
                                    title="Registrar"><i class="i i-Compose"></i> Registrar</a></center>
                        </p>
                    @endcan
                    <div id="payers" style="display:block;" class="box-body table-responsive">
                        <table id="payers-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Banco</center>
                                    </th>
                                    <th>
                                        <center>Tipo archivo</center>
                                    </th>
                                    <th>
                                        <center>No. Consecutivo</center>
                                    </th>
                                    <th>
                                        <center>Actualizado</center>
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

@include('parameters::payers.create')
@include('parameters::payers.edit')
@include('parameters::payers.delete')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $('#payers').show();
            listpayers();
        });
        var listpayers = function() {
            table = $('#payers-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/payers/datatable",
                columns: [{
                        data: "bank_name",
                        "className": "text-center"
                    },
                    {
                        data: "type_file",
                        "className": "text-center"
                    },
                    {
                        data: "consecutive",
                        "className": "text-center"
                    },
                    {
                        data: "updated",
                        "className": "text-center"
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

        $.get('/banks/select', function(data) {
            $('.bank_id').empty();
            $('.bank_id').append("<option value=''>Seleccione Banco...</option>");
            $.each(data, function(index, subBankObj) {
                $('.bank_id').append("<option value='" + subBankObj.id + "'>" + subBankObj.description +
                    "</option>");
            });
        });

        $("#create").click(function() {
            var consecutive = $("#consecutive").val();
            var bank_id = $("#bank_id").val();
            var type_file = $(".type_file").val();
            var is_active = 'on';

            var route = "{{ route('payers.store') }}";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'post',
                dataType: 'json',
                data: {
                    consecutive: consecutive,
                    type_file: type_file,
                    bank_id: bank_id,
                    is_active: is_active,
                },
                success: function(data) {
                    $("#payersCreate").modal("hide");
                    $("#form-create")[0].reset();
                    $('#payers-table').DataTable().ajax.reload();
                    toastr.info("Se ha Registrado Correctamente")
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subPayerObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subPayerObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subPayerObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var payers = function(btn) {
            val = btn.value;
            var route = "{{ url('payers') }}/" + val + "/edit";
            $.get(route, function(res) {
                $("#id").val(res.id);
                $("#consecutive_up").val(res.consecutive);
                $("#bank_name").val(res.bank_name);
                $("#type_file_up").val(res.type_file);
            });
        }

        $("#update").click(function() {
            var id = $("#id").val();
            var consecutive = $("#consecutive_up").val();

            var route = "{{ url('payers') }}/" + id;
            var token = $("#token").val();
            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'PUT',
                dataType: 'json',
                data: {
                    consecutive: consecutive,
                },

                success: function(data) {
                    $("#payersUpdate").modal("hide");
                    $("#form-edit")[0].reset();
                    $('#payers-table').DataTable().ajax.reload();
                    toastr.info("Registro se ha Actualizado Correctamente")

                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subPayerObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subPayerObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subPayerObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var payersDelete = function(btn) {
            $("#id").val(btn.value);
        }

        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('payers') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#payersDelete").modal("hide");
                    $('#payers-table').DataTable().ajax.reload();
                    toastr.info("Registro Eliminado Correctamente")
                },
                error: function(data) {
                    toastr.warning("Error al Eliminar Registro")
                }
            });
        });
    </script>
@endsection
