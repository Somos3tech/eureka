@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/datatables.min.css') }}">
    @toastr_css
@endsection

@section('main-content')
    <div class="breadcrumb">
        <h1>{{ $identity ?? 'Dashboard' }}</h1>

    </div>
    <div class="separator-breadcrumb border-top"></div>
    @can('permissions.create')
        <center>
            <p><a class="btn btn-sm btn-info" href="#" data-toggle="modal" data-target="#permissionsCreate" title="Ingresar"><i
                        class="ion-compose"></i> Registrar</a></p>
        </center>
    @endcan
    <div id="permissions" style="display:block;" class="box-body table-responsive">
        <table id="permissions-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>
                        <center>Nombre</center>
                    </th>
                    <th>
                        <center>Slug</center>
                    </th>
                    <th>
                        <center>Acciones</center>
                    </th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@include('users::permissions.create')
@include('users::permissions.edit')
@include('users::permissions.delete')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    @toastr_js
    @toastr_render
    <script type="text/javascript">
        $(document).ready(function() {
            $('#permissions').show();
            listpermission();
        });

        var listpermission = function() {
            table = $('#permissions-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "permissions/datatable",
                columns: [{
                        data: "description",
                    },
                    {
                        data: "name"
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
            var name = $("#name").val();
            var description = $("#description").val();
            var route = "{{ route('permissions.store') }}";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    name: name,
                    description: description
                },
                success: function(data) {
                    $("#permissionsCreate").modal("hide");
                    $("#form-create")[0].reset();
                    $('#permissions-table').DataTable().ajax.reload();
                    toastr.info("Se ha registrado Correctamente", "Ingreso Registro")

                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subApnkObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subApnkObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subApnkObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var permissions = function(btn) {
            val = btn.value;
            var route = "{{ url('permissions') }}/" + val + "/edit";
            $.get(route, function(res) {
                $("#id").val(res.id);
                $("#name_up").val(res.name);
                $("#description_up").val(res.description);
            })
        }

        $("#update").click(function() {
            var id = $("#id").val();
            var name = $("#name_up").val();
            var description = $("#description_up").val();
            var route = "{{ url('permissions') }}/" + id;
            var token = $("#token").val();
            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'PUT',
                dataType: 'json',
                data: {
                    name: name,
                    description: description
                },
                success: function(data) {
                    $("#permissionsUpdate").modal("hide");
                    $("#form-create")[0].reset();
                    $('#permissions-table').DataTable().ajax.reload();
                    toastr.info("Se ha Actualizado Correctamente", "Actualizar Registro")
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subApnkObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subApnkObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subApnkObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var permissionsDelete = function(btn) {
            $("#id").val(btn.value);
        }

        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('permissions') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#permissionsDelete").modal("hide");
                    $('#permissions-table').DataTable().ajax.reload();
                    toastr.info("Registrado Eliminado Correctamente", "Eliminar Registro")
                },
                error: function(data) {
                    toastr.warning("Hubo un error al Eliminar Registro", "Eliminar Registro")
                }
            });
        });

        $('.mayusc').keyup(function() {
            this.value = this.value.toUpperCase();
        });

        $('.minusc').keyup(function() {
            this.value = this.value.toLowerCase();
        });

        $('.blank').blur(function() {
            /* Obtengo el valor contenido dentro del input */
            var value = $(this).val();

            /* Elimino todos los espacios en blanco que tenga la cadena delante y detrás */
            var value_without_space = $.trim(value);

            /* Cambio el valor contenido por el valor sin espacios */
            $(this).val(value_without_space);
        });
    </script>
@endsection
