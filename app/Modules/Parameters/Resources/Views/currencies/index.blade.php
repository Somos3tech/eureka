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
                    @can('currencies.create')
                        <p>
                            <center><a class="btn btn-sm btn-info" href="#" data-toggle="modal"
                                    data-target="#currenciesCreate" title="Registrar"><i class="ion-compose"></i> Registrar</a>
                            </center>
                        </p>
                    @endcan
                    <div id="currencies" style="display:block;" class="box-body table-responsive">
                        <table id="currencies-table" class="table table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Denominación</center>
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

@include('parameters::currencies.create')
@include('parameters::currencies.edit')
@include('parameters::currencies.delete')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $('#currencies').show();
            listcurrencies();
        });
        var listcurrencies = function() {
            table = $('#currencies-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/currencies/datatable",
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
            var abrev = $("#abrev").val();
            var description = $("#description").val();
            var route = "{{ route('currencies.store') }}";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'post',
                dataType: 'json',
                data: {
                    abrev: abrev,
                    description: description
                },
                success: function(data) {
                    $("#currenciesCreate").modal("hide");
                    $("#form-create")[0].reset();
                    $('#currencies-table').DataTable().ajax.reload();
                    toastr.info("Se ha Registrado Correctamente")
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subCurrencyObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subCurrencyObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subCurrencyObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var currencies = function(btn) {
            val = btn.value;
            var route = "{{ url('currencies') }}/" + val + "/edit";
            $.get(route, function(res) {
                $("#id").val(res.id);
                $("#abrev_up").val(res.abrev);
                $("#description_up").val(res.description);
            })
        }
        $("#update").click(function() {
            var id = $("#id").val();
            var description = $("#description_up").val();
            var abrev = $("#abrev_up").val();
            var route = "{{ url('currencies') }}/" + id;
            var token = $("#token").val();
            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'PUT',
                dataType: 'json',
                data: {
                    abrev: abrev,
                    description: description
                },

                success: function(data) {
                    $("#currenciesUpdate").modal("hide");
                    $("#form-edit")[0].reset();
                    $('#currencies-table').DataTable().ajax.reload();
                    toastr.info("Registro se ha Actualizado Correctamente")

                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subCurrencyObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subCurrencyObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subCurrencyObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var currenciesDelete = function(btn) {
            $("#id").val(btn.value);
        }

        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('currencies') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#currenciesDelete").modal("hide");
                    $('#currencies-table').DataTable().ajax.reload();
                    toastr.info("Registro Eliminado Correctamente")
                },
                error: function(data) {
                    toastr.warning("Error al Eliminar Registro")
                }
            });
        });
    </script>
@endsection
