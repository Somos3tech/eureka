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
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    @can('business.create')
                        <p>
                            <center><a class="btn btn-sm btn-info" href="#" data-toggle="modal"
                                    data-target="#businessCreate" title="Registrar"><i class="ion-compose"></i> Registrar</a>
                            </center>
                        </p>
                    @endcan
                    <div id="business" style="display:block;" class="box-body table-responsive">
                        <table id="business-table" class="table table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Rif</center>
                                    </th>
                                    <th>
                                        <center>Nombre Empresa</center>
                                    </th>
                                    <th>
                                        <center>Dirección</center>
                                    </th>
                                    <th>
                                        <center>Teléfono</center>
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

@include('parameters::business.create')
@include('parameters::business.edit')
@include('parameters::business.delete')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $('#business').show();
            listbusiness();
        });
        var listbusiness = function() {
            table = $('#business-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/business/datatable",
                columns: [{
                        data: "rif",
                        "className": "text-center",
                    },
                    {
                        data: "name",
                        "className": "text-left",
                    },
                    {
                        data: "address",
                        "className": "text-left",
                    },
                    {
                        data: "phone",
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
            var rif = $("#rif").val();
            var name = $("#name").val();
            var address = $("#address").val();
            var phone = $("#phone").val();

            var route = "{{ route('business.store') }}";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'post',
                dataType: 'json',
                data: {
                    rif: rif,
                    name: name,
                    address: address,
                    phone: phone
                },
                success: function(data) {
                    $("#businessCreate").modal("hide");
                    $("#form-create")[0].reset();
                    $('#business-table').DataTable().ajax.reload();
                    toastr.info("Se ha Registrado Correctamente")
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subBusinessObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subBusinessObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subBusinessObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var business = function(btn) {
            val = btn.value;
            var route = "{{ url('business') }}/" + val + "/edit";
            $.get(route, function(res) {
                $("#id").val(res.id);
                $("#rif_up").val(res.rif);
                $("#name_up").val(res.name);
                $("#address_up").val(res.address);
                $("#phone_up").val(res.phone);
            })
        }
        $("#update").click(function() {
            var id = $("#id").val();
            var rif = $("#rif_up").val();
            var name = $("#name_up").val();
            var address = $("#address_up").val();
            var phone = $("#phone_up").val();
            var route = "{{ url('business') }}/" + id;
            var token = $("#token").val();
            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'PUT',
                dataType: 'json',
                data: {
                    rif: rif,
                    name: name,
                    address: address,
                    phone: phone
                },

                success: function(data) {
                    $("#businessUpdate").modal("hide");
                    $("#form-edit")[0].reset();
                    $('#business-table').DataTable().ajax.reload();
                    toastr.info("Registro se ha Actualizado Correctamente")

                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subBusinessObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subBusinessObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subBusinessObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var businessDelete = function(btn) {
            $("#id").val(btn.value);
        }

        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('business') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#businessDelete").modal("hide");
                    $('#business-table').DataTable().ajax.reload();
                    toastr.info("Registro Eliminado Correctamente")
                },
                error: function(data) {
                    toastr.warning("Error al Eliminar Registro")
                }
            });
        });

        $('.rif').keyup(function() {
            this.value = this.value.toUpperCase();
        });

        $('.rif').mask('S-AAAAAAAA-Y', {
            'translation': {
                S: {
                    pattern: /[CVEJPGRcvejpgr]{1}/
                },
                A: {
                    pattern: /[0-9]/
                },
                Y: {
                    pattern: /[0-9]/,
                    optional: true
                }
            }
        });

        $('.phone').mask('STAA-AAAAAAA', {
            'translation': {
                S: {
                    pattern: /[0]/
                },
                T: {
                    pattern: /[248]/
                },
                A: {
                    pattern: /[0-9]/
                }
            }
        });
    </script>
@endsection
