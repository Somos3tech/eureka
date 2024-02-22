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
                    @can('consultants.create')
                        <p>
                            <center><a class="btn btn-sm btn-info" href="#" data-toggle="modal"
                                    data-target="#consultantsCreate" title="Registrar"><i class="ion-compose"></i> Registrar</a>
                            </center>
                        </p>
                    @endcan
                    <div id="consultants" style="display:block;" class="box-body table-responsive">
                        <table id="consultants-table" class="table table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>No. Identificación</center>
                                    </th>
                                    <th>
                                        <center>RIF</center>
                                    </th>
                                    <th>
                                        <center>Nombres</center>
                                    </th>
                                    <th>
                                        <center>Apellidos</center>
                                    </th>
                                    <th>
                                        <center>Email</center>
                                    </th>
                                    <th>
                                        <center>Telefono</center>
                                    </th>
                                    <th>
                                        <center>SubZona Venta</center>
                                    </th>
                                    <th>
                                        <center>Asesor Asociado</center>
                                    </th>
                                    <th>
                                        <center>Status</center>
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

@include('parameters::consultants.create')
@include('parameters::consultants.edit')
@include('parameters::consultants.delete')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $.get('/users/select', function(data) {
                $('#user_id_c').empty();
                $('#user_id_c').append("<option value=''>Seleccione Asesor Venta...</option>");
                $.each(data, function(index, subUserObj) {
                    $('#user_id_c').append("<option value='" + subUserObj.id + "'>" + subUserObj
                        .description + "</option>");
                    $("#user_id_c option[value=" + {{ old('user_id') }} + "]").attr("selected",
                        true);
                });
            });

            $('#consultants').show();
            listconsultants();
        });
        var listconsultants = function() {
            table = $('#consultants-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/consultants/datatable",
                columns: [{
                        data: "document_number",
                        "className": "text-center"
                    },
                    {
                        data: "rif",
                        "className": "text-center"
                    },
                    {
                        data: "first_name",
                        "className": "text-left"
                    },
                    {
                        data: "last_name",
                        "className": "text-left"
                    },
                    {
                        data: "email",
                        "className": "text-left"
                    },
                    {
                        data: "telephone",
                        "className": "text-center"
                    },
                    {
                        data: "zone",
                        "className": "text-center"
                    },
                    {
                        data: "user_associated",
                        "className": "text-center"
                    },
                    {
                        data: "status",
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

        $('.document').on('blur', function(e) {
            var number_doc = e.target.value;
            var parts = number_doc.split("-");
            parts[1] = parts[1].padStart(8, '0');
            document.getElementById("document_number_c").value = parts.join("-");
            document.getElementById("document_number").value = parts.join("-");
        });

        $('.rif').on('blur', function(e) {
            var number_doc = e.target.value;
            var parts = number_doc.split("-");

            if (parts.length == 2) {
                var index = parts[1].substr(-1);
                parts[2] = index;
                parts[1] = parts[1].slice(0, -1);
                parts[1] = parts[1].padStart(8, '0');
            } else {
                if (parts.length > 2) {
                    if (parts[2] == "") {
                        var index = parts[1].substr(-1);
                        parts[2] = index;
                        parts[1] = parts[1].slice(0, -1);
                        parts[1] = parts[1].padStart(8, '0');
                    }
                }
            }
            document.getElementById("rif_c").value = parts.join("-");
            document.getElementById("rif").value = parts.join("-");
        });

        $("#create").click(function() {
            var document_number = $("#document_number_c").val();
            var rif = $("#rif_c").val();
            var first_name = $("#first_name_c").val();
            var last_name = $("#last_name_c").val();
            var email = $("#email_c").val();
            var observation = $("#observation_c").val();
            var telephone = $("#telephone_c").val();
            var zone = $("#zone_c").val();
            var user_id = $("#user_id_c").val();
            var status = $("#status_c").val();
            var route = "{{ route('consultants.store') }}";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'post',
                dataType: 'json',
                data: {
                    document_number: document_number,
                    rif: rif,
                    first_name: first_name,
                    last_name: last_name,
                    email: email,
                    observation: observation,
                    telephone: telephone,
                    zone: zone,
                    user_id: user_id,
                    status: status,
                },
                success: function(data) {
                    $("#consultantsCreate").modal("hide");
                    $("#form-create")[0].reset();
                    $('#consultants-table').DataTable().ajax.reload();
                    toastr.info("Se ha Registrado Correctamente")
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subConsultantObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subConsultantObj[0] +
                                '</li>';
                        } else {
                            notification = '<li>' + subConsultantObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var consultants = function(btn) {
            val = btn.value;
            var route = "{{ url('consultants') }}/" + val + "/edit";
            $.get(route, function(res) {
                $("#id").val(res.id);
                $("#document_number").val(res.document_number);
                $("#rif").val(res.rif);
                $("#first_name").val(res.first_name);
                $("#last_name").val(res.last_name);
                $("#email").val(res.email);
                $("#telephone").val(res.telephone);
                $("#observations").val(res.observation);
                $("#zone").val(res.zone);

                $.get('/users/select', function(data) {
                    $('#user_id').empty();
                    $('#user_id').append("<option value=''>Seleccione Asesor Venta...</option>");
                    $.each(data, function(index, subUserObj) {
                        $('#user_id').append("<option value='" + subUserObj.id + "'>" +
                            subUserObj.description + "</option>");
                    });
                    $("#user_id option[value=" + res.user_id + "]").attr("selected", true);
                });
            })
        }
        $("#update").click(function() {
            var id = $("#id").val();
            var document_number = $("#document_number").val();
            var rif = $("#rif").val();
            var first_name = $("#first_name").val();
            var last_name = $("#last_name").val();
            var email = $("#email").val();
            var observation = $("#observations").val();
            var telephone = $("#telephone").val();
            var zone = $("#zone").val();
            var user_id = $("#user_id").val();
            var status = $("#statusup").val();
            var route = "{{ url('consultants') }}/" + id;
            var token = $("#token").val();
            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'PUT',
                dataType: 'json',
                data: {
                    id: id,
                    document_number: document_number,
                    rif: rif,
                    first_name: first_name,
                    last_name: last_name,
                    email: email,
                    observation: observation,
                    telephone: telephone,
                    zone: zone,
                    user_id: user_id,
                    status: status,
                },

                success: function(data) {
                    $("#consultantsUpdate").modal("hide");
                    $("#form-edit")[0].reset();
                    $('#consultants-table').DataTable().ajax.reload();
                    toastr.info("Registro se ha Actualizado Correctamente")

                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subConsultantObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subConsultantObj[0] +
                                '</li>';
                        } else {
                            notification = '<li>' + subConsultantObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var consultantsDelete = function(btn) {
            $("#id").val(btn.value);
        }

        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('consultants') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#consultantsDelete").modal("hide");
                    $('#consultants-table').DataTable().ajax.reload();
                    toastr.info("Registro Eliminado Correctamente")
                },
                error: function(data) {
                    toastr.warning("Error al Eliminar Registro")
                }
            });
        });

        $('.document').keyup(function() {
            this.value = this.value.toUpperCase();
        });

        $('.document').mask('S-AAAAAAAA', {
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
