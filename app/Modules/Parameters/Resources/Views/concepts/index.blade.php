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
                    @can('concept.create')
                        <p>
                            <center><a class="btn btn-sm btn-info" href="#" data-toggle="modal"
                                    data-target="#conceptsCreate" title="Registrar"><i class="ion-compose"></i> Registrar</a>
                            </center>
                        </p>
                    @endcan
                    <div id="concepts" style="display:block;" class="box-body table-responsive">
                        <table id="concepts-table" class="table table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Abreviatura</center>
                                    </th>
                                    <th>
                                        <center>Descripcion</center>
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

@include('parameters::concepts.create')
@include('parameters::concepts.edit')
@include('parameters::concepts.delete')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $('#concepts').show();
            listconcepts();
        });
        var listconcepts = function() {
            table = $('#concepts-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/concepts/datatable",
                columns: [{
                        data: "abrev",
                        "className": "text-center"
                    },
                    {
                        data: "description",
                        "className": "text-left"
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
            var description = $("#description").val();
            var abrev = $("#abrev").val();
            var route = "{{ route('concepts.store') }}";
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
                    abrev: abrev
                },
                success: function(data) {
                    $("#conceptsCreate").modal("hide");
                    $("#form-create")[0].reset();
                    $('#concepts-table').DataTable().ajax.reload();
                    toastr.info("Se ha Registrado Correctamente")
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subConceptObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subConceptObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subConceptObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var concept = function(btn) {
            val = btn.value;
            var route = "{{ url('concepts') }}/" + val + "/edit";
            $.get(route, function(res) {
                $("#id").val(res.id);
                $("#descriptionup").val(res.description);
                $("#abrevup").val(res.abrev);
            })
        }
        $("#update").click(function() {
            var id = $("#id").val();
            var description = $("#descriptionup").val();
            var abrev = $("#abrevup").val();
            var route = "{{ url('concepts') }}/" + id;
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
                    abrev: abrev
                },

                success: function(data) {
                    $("#conceptUpdate").modal("hide");
                    $("#form-edit")[0].reset();
                    $('#concepts-table').DataTable().ajax.reload();
                    toastr.info("Registro se ha Actualizado Correctamente")

                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subConceptObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subConceptObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subConceptObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var conceptDelete = function(btn) {
            $("#id").val(btn.value);
        }

        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('concepts') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#conceptDelete").modal("hide");
                    $('#concepts-table').DataTable().ajax.reload();
                    toastr.info("Registro Eliminado Correctamente")
                },
                error: function(data) {
                    toastr.warning("Error al Eliminar Registro")
                }
            });
        });
    </script>
@endsection
