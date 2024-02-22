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
                    @can('company.create')
                        <p>
                            <center><a class="btn btn-sm btn-info" href="#" data-toggle="modal"
                                    data-target="#companiesCreate" title="Registrar"><i class="ion-compose"></i> Registrar</a>
                            </center>
                        </p>
                    @endcan
                    <div id="companies" style="display:block;" class="box-body table-responsive">
                        <table id="companies-table" class="table table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Nombre Almacén</center>
                                    </th>
                                    <th>
                                        <center>Empresa</center>
                                    </th>
                                    <th>
                                        <center>Tipo Almacén</center>
                                    </th>
                                    <th>
                                        <center>Es Distribuidor</center>
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

@include('parameters::companies.create')
@include('parameters::companies.edit')
@include('parameters::companies.delete')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>

    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $.get('{{ route('business.select') }}', function(data) {
                $('.business').empty();
                $('.business').append("<option value=''>Seleccione Empresa...</option>");
                $.each(data, function(index, subBusinessObj) {
                    $('.business').append("<option value='" + subBusinessObj.id + "'>" +
                        subBusinessObj.description + "</option>");
                });
            });
            /************************************************************************/
            $.get('{{ route('typecompanies.select') }}', function(data) {
                $('.typecompany').empty();
                $('.typecompany').append("<option value=''>Seleccione Tipo Almacén...</option>");
                $.each(data, function(index, subTypeCompanyObj) {
                    $('.typecompany').append("<option value='" + subTypeCompanyObj.id + "'>" +
                        subTypeCompanyObj.description + "</option>");
                });
            });
            $('#companies').show();
            listcompanies();
        });
        /**************************************************************************/
        var listcompanies = function() {
            table = $('#companies-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/companies/datatable",
                columns: [{
                        data: "description",
                        "className": "text-left"
                    },
                    {
                        data: "name_business",
                        "className": "text-center"
                    },
                    {
                        data: "name_typecompany",
                        "className": "text-center"
                    },
                    {
                        data: "wholesaler",
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
        /**************************************************************************/
        $("#create").click(function() {
            if (document.getElementById("is_wholesaler").checked) {
                document.getElementById("is_wholesaler").value = 'on';
            } else {
                document.getElementById("is_wholesaler").value = '';
            }
            var description = $("#description").val();
            var business_id = $("#business_id").val();
            var typecompany_id = $("#typecompany_id").val();
            var is_wholesaler = $("#is_wholesaler").val();
            var route = "{{ route('companies.store') }}";
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
                    business_id: business_id,
                    typecompany_id: typecompany_id,
                    is_wholesaler: is_wholesaler
                },
                success: function(data) {
                    $("#companiesCreate").modal("hide");
                    $("#form-create")[0].reset();
                    $('#companies-table').DataTable().ajax.reload();
                    toastr.info("Se ha Registrado Correctamente")
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subCompanyObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subCompanyObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subCompanyObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });
        /**************************************************************************/
        var company = function(btn) {
            val = btn.value;
            var route = "{{ url('companies') }}/" + val + "/edit";
            $.get(route, function(res) {
                $("#id").val(res.id);
                $("#description_up").val(res.description);
                $("#business_id_up option[value=" + res.business_id + "]").attr("selected", true);
                $("#typecompany_id_up option[value=" + res.typecompany_id + "]").attr("selected", true);

                if (res.is_wholesaler == 1) {
                    document.getElementById("is_wholesaler_up").checked = true;
                } else {
                    document.getElementById("is_wholesaler_up").checked = false;
                }
            })
        }
        /**************************************************************************/
        $("#update").click(function() {
            if (document.getElementById("is_wholesaler_up").checked) {
                document.getElementById("is_wholesaler_up").value = 'on';
            } else {
                document.getElementById("is_wholesaler_up").value = '';
            }
            var id = $("#id").val();
            var description = $("#description_up").val();
            var business_id = $("#business_id_up").val();
            var typecompany_id = $("#typecompany_id_up").val();
            var is_wholesaler = $("#is_wholesaler_up").val();
            var route = "{{ url('companies') }}/" + id;
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
                    business_id: business_id,
                    typecompany_id: typecompany_id,
                    is_wholesaler: is_wholesaler
                },

                success: function(data) {
                    $("#companyUpdate").modal("hide");
                    $("#form-edit")[0].reset();
                    $('#companies-table').DataTable().ajax.reload();
                    toastr.info("Registro se ha Actualizado Correctamente")

                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subCompanyObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subCompanyObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subCompanyObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });
        /**************************************************************************/
        var companyDelete = function(btn) {
            $("#id").val(btn.value);
        }
        /**************************************************************************/
        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('companies') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#companyDelete").modal("hide");
                    $('#companies-table').DataTable().ajax.reload();
                    toastr.info("Registro Eliminado Correctamente")
                },
                error: function(data) {
                    toastr.warning("Error al Eliminar Registro")
                }
            });
        });
    </script>
@endsection
