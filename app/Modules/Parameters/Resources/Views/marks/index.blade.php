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
                    @can('marks.create')
                        <p>
                            <center><a class="btn btn-sm btn-info" href="#" data-toggle="modal" data-target="#marksCreate"
                                    title="Registrar"><i class="ion-compose"></i> Registrar</a></center>
                        </p>
                    @endcan
                    <div id="marks" style="display:block;" class="box-body table-responsive">
                        <table id="marks-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
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

@include('parameters::marks.create')
@include('parameters::marks.edit')
@include('parameters::marks.delete')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $('#marks').show();
            listmarks();
        });
        var listmarks = function() {
            table = $('#marks-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/marks/datatable",
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
            var route = "{{ route('marks.store') }}";
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
                    $("#marksCreate").modal("hide");
                    $("#form-create")[0].reset();
                    $('#marks-table').DataTable().ajax.reload();
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

        var marks = function(btn) {
            val = btn.value;
            var route = "{{ url('marks') }}/" + val + "/edit";
            $.get(route, function(res) {
                $("#id").val(res.id);
                $("#description_up").val(res.description);
            })
        }
        $("#update").click(function() {
            var id = $("#id").val();
            var description = $("#description_up").val();
            var route = "{{ url('marks') }}/" + id;
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
                    $("#marksUpdate").modal("hide");
                    $("#form-edit")[0].reset();
                    $('#marks-table').DataTable().ajax.reload();
                    toastr.info("Registro se ha Actualizado Correctamente")

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

        var marksDelete = function(btn) {
            $("#id").val(btn.value);
        }

        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('marks') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#marksDelete").modal("hide");
                    $('#marks-table').DataTable().ajax.reload();
                    toastr.info("Registro Eliminado Correctamente")
                },
                error: function(data) {
                    toastr.warning("Error al Eliminar Registro")
                }
            });
        });
    </script>
@endsection
