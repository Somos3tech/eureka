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
                    @can('banks.create')
                        <p>
                            <center><a class="btn btn-sm btn-info" href="#" data-toggle="modal" data-target="#banksCreate"
                                    title="Registrar"><i class="ion-compose"></i> Registrar</a></center>
                        </p>
                    @endcan
                    <div id="banks" style="display:block;" class="box-body table-responsive">
                        <table id="banks-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Nombre Banco</center>
                                    </th>
                                    <th>
                                        <center>RIF</center>
                                    </th>
                                    <th>
                                        <center>Direccion</center>
                                    </th>
                                    <th>
                                        <center>Código Banco</center>
                                    </th>
                                    <th>
                                        <center>Validación Bancaría</center>
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

@include('parameters::banks.create')
@include('parameters::banks.edit')
@include('parameters::banks.delete')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $('#banks').show();
            listbanks();
        });
        var listbanks = function() {
            table = $('#banks-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/banks/datatable",
                columns: [{
                        data: "description"
                    },
                    {
                        data: "rif",
                        "className": "text-center"
                    },
                    {
                        data: "address",
                    },
                    {
                        data: "bank_code",
                        "className": "text-center"
                    },
                    {
                        data: "is_register",
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
        $("#create").click(function() {
            if (document.getElementById("is_register").checked) {
                document.getElementById("is_register").value = 'on';
            } else {
                document.getElementById("is_register").value = '';
            }
            var description = $("#description").val();
            var rif = $("#rif").val();
            var address = $("#address").val();
            var bank_code = $("#bank_code").val();
            var is_register = $("#is_register").val();

            var route = "{{ route('banks.store') }}";
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
                    rif: rif,
                    address: address,
                    bank_code: bank_code,
                    is_register: is_register
                },
                success: function(data) {
                    $("#banksCreate").modal("hide");
                    $("#form-create")[0].reset();
                    $('#banks-table').DataTable().ajax.reload();
                    toastr.info("Se ha Registrado Correctamente")
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subBankObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subBankObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subBankObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var banks = function(btn) {
            val = btn.value;
            var route = "{{ url('banks') }}/" + val + "/edit";
            $.get(route, function(res) {
                $("#id").val(res.id);
                $("#descriptionup").val(res.description);
                $("#rifup").val(res.rif);
                $("#addressup").val(res.address);
                $("#bank_codeup").val(res.bank_code);
                if (res.is_register == 1) {
                    document.getElementById("is_register_up").checked = true;
                } else {
                    document.getElementById("is_register_up").checked = false;
                }
            })
        }
        $("#update").click(function() {
            if (document.getElementById("is_register_up").checked) {
                document.getElementById("is_register_up").value = 'on';
            } else {
                document.getElementById("is_register_up").value = '';
            }
            var id = $("#id").val();
            var description = $("#descriptionup").val();
            var rif = $("#rifup").val();
            var address = $("#addressup").val();
            var bank_code = $("#bank_codeup").val();
            var is_register = $("#is_register_up").val();

            var route = "{{ url('banks') }}/" + id;
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
                    rif: rif,
                    address: address,
                    bank_code: bank_code,
                    is_register: is_register
                },

                success: function(data) {
                    $("#banksUpdate").modal("hide");
                    $("#form-edit")[0].reset();
                    $('#banks-table').DataTable().ajax.reload();
                    toastr.info("Registro se ha Actualizado Correctamente")

                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subBankObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subBankObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subBankObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var banksDelete = function(btn) {
            $("#id").val(btn.value);
        }

        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('banks') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#banksDelete").modal("hide");
                    $('#banks-table').DataTable().ajax.reload();
                    toastr.info("Registro Eliminado Correctamente")
                },
                error: function(data) {
                    toastr.warning("Error al Eliminar Registro")
                }
            });
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

        $('.mayusc').keyup(function() {
            this.value = this.value.toUpperCase();
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

        $('.code').mask('AAAA', {
            'translation': {
                A: {
                    pattern: /[0-9]/
                }
            }
        });
    </script>
@endsection
