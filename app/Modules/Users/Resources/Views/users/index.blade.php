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

    <!-- Content-->
    @can('users.create')
        <center><a class="btn btn-sm btn-info" href="{{ route('users.create') }}"><i class="dripicons-user"></i> Registrar</a>
        </center>
    @endcan
    <div class="btn-group btn-sm pull-right">
        <button type="button" class="btn btn-sm btn-dark ">Filtro(s)</button>
        <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-toggle="dropdown"></button>
        <ul class="dropdown-menu" role="menu">
            <li><a id="active" class="btn btn-sm btn-default filter">Activo</a></li>
            <li><a id="inactive" class="btn btn-sm btn-default filter">Suspendido</a></li>
        </ul>
    </div>
    <div id="users" style="display:block;" class="box-body table-responsive">
        <table id="users-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>
                        <center>Acciones</center>
                    </th>
                    <th>
                        <center>Nombre Usuario</center>
                    </th>
                    <th>
                        <center>Email</center>
                    </th>
                    <th>
                        <center>Zona/Almacén</center>
                    </th>
                    <th>
                        <center>Perfil</center>
                    </th>
                    <th>
                        <center>Estado</center>
                    </th>
                    <th>
                        <center>Cargo</center>
                    </th>
                </tr>
            </thead>
        </table>
    </div><!-- div table -->
    <!-- Content-->
@endsection

@include('users::users.delete')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
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
            $('#users').show();
            listuser();
            table.columns(5).search('Activo').draw();
        });

        var listuser = function() {
            table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/users/datatable",
                columns: [{
                        data: "actions",
                        "className": "text-center"
                    },
                    {
                        data: "name",
                        "className": "text-left"
                    },
                    {
                        data: "email",
                        "className": "text-left"
                    },
                    {
                        data: "company",
                        "className": "text-center"
                    },
                    {
                        data: "profile",
                        "className": "text-center"
                    },
                    {
                        data: "status",
                        "className": "text-center"
                    },
                    {
                        data: "jobtitle",
                        "className": "text-left"
                    },
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: []
            });

            $('#active').on('click', function() {
                table.columns(5).search('Activo').draw();
            });

            $('#inactive').on('click', function() {
                table.columns(5).search('Inactivo').draw();
            });
        }

        var usersDelete = function(btn) {
            $("#id").val(btn.value);
        }

        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('users') }}/" + id + "";

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#usersDelete").modal("hide");
                    $('#users-table').DataTable().ajax.reload();
                    toastr.info("Registro Eliminado Correctamente")
                },
                error: function(data) {
                    $('#users-table').DataTable().ajax.reload();
                    toastr.warning("Hubo un error al Eliminar Registro")
                }
            });
        });
    </script>
@endsection
