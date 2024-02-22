@extends('layouts.compact-master')

@section('page-css')
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
                    @can('acconcept.create')
                        <center>
                            <p><a class="btn btn-sm btn-dark" href="#" data-toggle="modal" data-target="#acconceptsCreate"
                                    title="Registrar"><i class="ion-compose"></i> Registrar</a></p>
                        </center>
                    @endcan
                    <ul id="tree1">
                        @foreach ($acconcept as $category)
                            <li>
                                {!! $category->order !!} {!! $category->name !!}
                                @if (count($category->childs))
                                    @include('parameters::acconcepts.manageChild', [
                                        'childs' => $category->childs,
                                        'ident' => $category,
                                    ])
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Content-->
@endsection

@include('parameters::acconcepts.create')
@include('parameters::acconcepts.edit')
@include('parameters::acconcepts.delete')

@section('page-js')
    <script type="text/javascript">
        $(document).ready(function() {
            $.get('/acconcepts/select', function(data) {
                $('.acconcept').empty();
                $('.acconcept').append("<option value=''>Seleccione Categoría Padre...</option>");
                $.each(data, function(index, subAcconceptObj) {
                    $('.acconcept').append("<option value='" + subAcconceptObj.id + "'>" +
                        subAcconceptObj.description + "</option>");
                });
            });
        });

        $("#create").click(function() {
            var parent_id = $("#parent_id").val();
            var name = $("#name").val();
            var codcta = $("#codcta").val();
            var tipmon = $("#tipmon").val();
            var forma_pago = $("#forma_pago").val();
            var order = $("#order").val();

            var route = "{{ route('acconcepts.store') }}";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'post',
                dataType: 'json',
                data: {
                    parent_id: parent_id,
                    order: order,
                    codcta: codcta,
                    tipmon: tipmon,
                    forma_pago: forma_pago,
                    name: name
                },
                success: function(data) {
                    $("#acconceptsCreate").modal("hide");
                    $("#form-create")[0].reset();
                    toastr.info("Se ha Registrado Correctamente")
                    location.reload();
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subAcconceptObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subAcconceptObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subAcconceptObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var acconcepts = function(btn) {
            val = btn;
            var route = "{{ url('acconcepts') }}/" + val + "/edit";
            $.get(route, function(res) {
                $("#id").val(res.id);
                $("#parent_id_up option[value=" + res.parent_id + "]").attr("selected", true);
                $("#nameup").val(res.name);
                $("#codctaup").val(res.codcta);
                $("#tipmonup").val(res.tipmon);
                $("#forma_pagoup").val(res.forma_pago);
                $("#orderup").val(res.order);
            })
        }

        $("#update").click(function() {
            var id = $("#id").val();
            var parent_id = $("#parent_id_up").val();
            var name = $("#nameup").val();
            var codcta = $("#codctaup").val();
            var tipmon = $("#tipmonup").val();
            var forma_pago = $("#forma_pagoup").val();
            var order = $("#orderup").val();
            var route = "{{ url('acconcepts') }}/" + id;
            var token = $("#token").val();
            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'PUT',
                dataType: 'json',
                data: {
                    parent_id: parent_id,
                    order: order,
                    codcta: codcta,
                    tipmon: tipmon,
                    forma_pago: forma_pago,
                    name: name
                },

                success: function(data) {
                    $("#acconceptsUpdate").modal("hide");
                    $("#form-edit")[0].reset();
                    toastr.info("Registro se ha Actualizado Correctamente")
                    location.reload();
                },
                error: function(data) {
                    var notification = '';
                    $.each(data.responseJSON.errors, function(index, subAcconceptObj) {
                        if (notification != '') {
                            notification = notification + '<li>' + subAcconceptObj[0] + '</li>';
                        } else {
                            notification = '<li>' + subAcconceptObj[0] + '</li>';
                        }
                    });
                    toastr.error("Error el los siguientes Campos: </br>" + notification)
                }
            });
        });

        var acconceptsDelete = function(btn) {
            $("#id").val(btn.value);
        }

        $("#delete").click(function() {
            var id = $("#id").val();
            var route = "{{ url('acconcepts') }}/" + id + "";
            var token = $("#token").val();

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'DELETE',
                dataType: 'json',
                success: function(data) {
                    $("#marksDelete").modal("hide");
                    $('#marks-table').DataTable().ajax.reload();
                    toastr.info("Registro Eliminado Correctamente")
                },
                error: function(data) {
                    toastr.warning("Error al Eliminar Registro")
                }
            });
        });
    </script>
@endsection
