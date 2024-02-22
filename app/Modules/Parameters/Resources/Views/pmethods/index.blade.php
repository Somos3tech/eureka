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
                    @can('pmethods.create')
                        <p>
                            <center><a class="btn btn-sm btn-info" href="#" data-toggle="modal"
                                    data-target="#pmethodsCreate" title="Registrar"><i class="ion-compose"></i> Registrar</a>
                            </center>
                        </p>
                    @endcan
                    <div id="pmethods" style="display:block;" class="box-body table-responsive">
                        <table id="pmethods-table" class="table table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Abreviatura</center>
                                    </th>
                                    <th>
                                        <center>Método Pago</center>
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

@include('parameters::pmethods.create')
@include('parameters::pmethods.edit')
@include('parameters::pmethods.delete')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $('#pmethods').show();
            listpmethods();
        });
        var listpmethods = function() {
            table = $('#pmethods-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/pmethods/datatable",
                columns: [{
                        data: "slug",
                        "className": "text-center",
                    },
                    {
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
            var slug = $("#slug").val();
            var description = $("#description").val();
            var route = "{{ route('pmethods.store') }}";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'post',
                dataType: 'json',
                data: {
                    slug: slug,
                    description: description
                },
                success: function(data) {
                    $("#pmethodsCreate").modal("hide");
                    $("#form-create")[0].reset();
                    $('#pmethods-table').DataTable().ajax.reload();
                    toastr.info("Se ha Registrado Correctamente")
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subPmethodObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subPmethodObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subPmethodObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var pmethods = function(btn) {
            val = btn.value;
            var route = "{{ url('pmethods') }}/" + val + "/edit";
            $.get(route, function(res) {
                $("#id").val(res.id);
                $("#slug_up").val(res.slug);
                $("#description_up").val(res.description);
            })
        }
        $("#update").click(function() {
            var id = $("#id").val();
            var slug = $("#slug_up").val();
            var description = $("#description_up").val();
            var route = "{{ url('pmethods') }}/" + id;
            var token = $("#token").val();
            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'PUT',
                dataType: 'json',
                data: {
                    slug: slug,
                    description: description
                },

                success: function(data) {
                    $("#pmethodsUpdate").modal("hide");
                    $("#form-edit")[0].reset();
                    $('#pmethods-table').DataTable().ajax.reload();
                    toastr.info("Registro se ha Actualizado Correctamente")

                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subPmethodObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subPmethodObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subPmethodObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var pmethodsDelete = function(btn) {
            $("#id").val(btn.value);
        }

        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('pmethods') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#pmethodsDelete").modal("hide");
                    $('#pmethods-table').DataTable().ajax.reload();
                    toastr.info("Registro Eliminado Correctamente")
                },
                error: function(data) {
                    toastr.warning("Hubo un error al Eliminar Registro")
                }
            });
        });
    </script>
@endsection
