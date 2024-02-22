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
                    @can('mterminal.create')
                        <p>
                            <center><a class="btn btn-sm btn-info" href="#" data-toggle="modal"
                                    data-target="#mterminalsCreate" title="Registrar"><i class="ion-compose"></i> Registrar</a>
                            </center>
                        </p>
                    @endcan
                    <div id="mterminals" style="display:block;" class="box-body table-responsive">
                        <table id="mterminals-table" class="table table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Modelo</center>
                                    </th>
                                    <th>
                                        <center>Marca</center>
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

@include('parameters::mterminals.create')
@include('parameters::mterminals.edit')
@include('parameters::mterminals.delete')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $('#mterminals').show();
            listmterminals();
        });
        var listmterminals = function() {
            table = $('#mterminals-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/mterminals/datatable",
                columns: [{
                        data: "description",
                    },
                    {
                        data: "mark",
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

        $.get('/marks/select', function(data) {
            $('.mark_id').empty();
            $('.mark_id').append("<option value=''>Seleccione Marca...</option>");
            $.each(data, function(index, subMarkObj) {
                $('.mark_id').append("<option value='" + subMarkObj.id + "'>" + subMarkObj.description +
                    "</option>");
            });
        });


        $("#create").click(function() {
            var description = $("#description").val();
            var mark_id = $("#mark_id").val();
            var route = "{{ route('mterminals.store') }}";
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
                    mark_id: mark_id
                },
                success: function(data) {
                    $("#mterminalsCreate").modal("hide");
                    $("#form-create")[0].reset();
                    $('#mterminals-table').DataTable().ajax.reload();
                    toastr.info("Se ha Registrado Correctamente")
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subMterminalObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subMterminalObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subMterminalObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var mterminal = function(btn) {
            val = btn.value;
            var route = "{{ url('mterminals') }}/" + val + "/edit";
            $.get(route, function(res) {
                $("#id").val(res.id);
                $("#descriptionup").val(res.description);
                $("#markup_id option[value=" + res.mark_id + "]").attr("selected", true);
            });
        }

        $("#update").click(function() {
            var id = $("#id").val();
            var description = $("#descriptionup").val();
            var mark_id = $("#markup_id").val();
            var route = "{{ url('mterminals') }}/" + id;
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
                    mark_id: mark_id
                },

                success: function(data) {
                    $("#mterminalUpdate").modal("hide");
                    $("#form-edit")[0].reset();
                    $('#mterminals-table').DataTable().ajax.reload();
                    toastr.info("Registro se ha Actualizado Correctamente")

                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subMterminalObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subMterminalObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subMterminalObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var mterminalDelete = function(btn) {
            $("#id").val(btn.value);
        }

        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('mterminals') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#mterminalDelete").modal("hide");
                    $('#mterminals-table').DataTable().ajax.reload();
                    toastr.info("Registro Eliminado Correctamente")
                },
                error: function(data) {
                    toastr.warning("Error al Eliminar Registro")
                }
            });
        });
    </script>
@endsection
