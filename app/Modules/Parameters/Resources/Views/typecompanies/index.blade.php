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
                    @can('typecompanies.create')
                        <p>
                            <center><a class="btn btn-sm btn-info" href="#" data-toggle="modal"
                                    data-target="#typecompaniesCreate" title="Registrar"><i class="ion-compose"></i>
                                    Registrar</a></center>
                        </p>
                    @endcan
                    <div id="typecompanies" style="display:block;" class="box-body table-responsive">
                        <table id="typecompanies-table" class="table table-striped table-bordered" cellspacing="0"
                            width="100%">
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

@include('parameters::typecompanies.create')
@include('parameters::typecompanies.edit')
@include('parameters::typecompanies.delete')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $('#typecompanies').show();
            listtypecompanies();
        });
        var listtypecompanies = function() {
            table = $('#typecompanies-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/typecompanies/datatable",
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
            var route = "{{ route('typecompanies.store') }}";
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
                    $("#typecompaniesCreate").modal("hide");
                    $("#form-create")[0].reset();
                    $('#typecompanies-table').DataTable().ajax.reload();
                    toastr.info("Se ha Registrado Correctamente")
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subTypeCompanyObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subTypeCompanyObj[0] +
                                '</li>';
                        } else {
                            notification = '<li>' + subTypeCompanyObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var typecompanies = function(btn) {
            val = btn.value;
            var route = "{{ url('typecompanies') }}/" + val + "/edit";
            $.get(route, function(res) {
                $("#id").val(res.id);
                $("#description_up").val(res.description);
            })
        }
        $("#update").click(function() {
            var id = $("#id").val();
            var description = $("#description_up").val();
            var route = "{{ url('typecompanies') }}/" + id;
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
                    $("#typecompaniesUpdate").modal("hide");
                    $("#form-edit")[0].reset();
                    $('#typecompanies-table').DataTable().ajax.reload();
                    toastr.info("Registro se ha Actualizado Correctamente")
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subTypeCompanyObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subTypeCompanyObj[0] +
                                '</li>';
                        } else {
                            notification = '<li>' + subTypeCompanyObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var typecompaniesDelete = function(btn) {
            $("#id").val(btn.value);
        }

        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('typecompanies') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#typecompaniesDelete").modal("hide");
                    $('#typecompanies-table').DataTable().ajax.reload();
                    toastr.info("Registro Eliminado Correctamente")
                },
                error: function(data) {
                    toastr.warning("Error al Eliminar Registro")
                }
            });
        });
    </script>
@endsection
