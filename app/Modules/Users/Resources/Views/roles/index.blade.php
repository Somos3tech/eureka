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
        <center><a class="btn btn-sm btn-info float-center" href="{{ route('roles.create') }}"> Crear Perfíl</a></center>
    @endcan
    <div id="roles" style="display:block;" class="box-body table-responsive">
        <table id="roles-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
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

@include('users::roles.delete')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    @toastr_js
    @toastr_render
    <script type="text/javascript">
        $(document).ready(function() {
            $('#roles').show();
            listrole();
        });

        var listrole = function() {
            table = $('#roles-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "roles/datatable",
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

        var rolesDelete = function(btn) {
            $("#id").val(btn.value);
        }

        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('roles') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#rolesDelete").modal("hide");
                    $('#roles-table').DataTable().ajax.reload();
                    toastr.info("Registrado Eliminado Correctamente", "Eliminar Registro")
                },
                error: function(data) {
                    toastr.warning("Hubo un error al Eliminar Registro", "Eliminar Registro")
                }
            });
        });
    </script>
@endsection
