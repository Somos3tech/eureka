@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/datatables.min.css') }}">
    @toastr_css
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = false;

        var pusher = new Pusher('9c5adc53b2e448ef6001', {
            cluster: 'mt1'
        });

        var channel = pusher.subscribe('atc');
        channel.bind('atc-total', function(data) {
            $.get('/atcs/totalStatus', function(data) {
                var total_ticket = 0;
                $.each(data, function(index, subAtcObj) {
                    $("#atc-" + subAtcObj.atc_status).empty();
                    $("#atc-" + subAtcObj.atc_status).append(subAtcObj.total);
                    if (subAtcObj.atc_status == 'G' || subAtcObj.atc_status == 'P' || subAtcObj
                        .atc_status == 'F' || subAtcObj.atc_status == 'X') {
                        total_ticket = total_ticket + subAtcObj.total;
                    }
                });
                $("#atc-total").empty();
                $("#atc-total").append(total_ticket);
            });
            toastr.info("SAC Creado / Procesado")
        });
    </script>
@endsection

@section('main-content')
    <div class="breadcrumb">
        <h1>{{ $identity ?? 'Dashboard' }}</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    @can('atcs.index')
        <div class="row">
            <div class="col-lg-12 row">
                <div class="card-body">
                    <h5 class="mt-0 header-title"><b>Gestión SAC</b></h5>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Box-Full"></i>
                        <div class="content">
                            <center>
                                <h6 class="mb-0">
                                    <b><span id="atc-total" name="atc-total" class="atc-total"
                                            style="font-size:15px;">0</span></b>
                                </h6>
                                <p class="text-muted font-12">Total</p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Gear"></i>
                        <div class="content">
                            <center>
                                <h6 class="mb-0">
                                    <b><span id="atc-G" name="atc-G" class="atc-G" style="font-size:15px;">0</span></b>
                                </h6>
                                <p class="text-muted font-12">Sin Gestión</p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Gears"></i>
                        <div class="content">
                            <center>
                                <h6 class="mb-0">
                                    <b><span id="atc-P" name="atc-P" class="atc-P" style="font-size:15px;">0</span></b>
                                </h6>
                                <p class="text-muted font-12">En Gestión</p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Yes"></i>
                        <div class="content">
                            <center>
                                <h6 class="mb-0">
                                    <b><span id="atc-F" name="atc-F" class="atc-F" style="font-size:15px;">0</span></b>
                                </h6>
                                <p class="text-muted font-12">Procesados</p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Close"></i>
                        <div class="content">
                            <center>
                                <h6 class="mb-0">
                                    <b><span id="atc-X" name="atc-X" class="atc-X" style="font-size:15px;">0</span></b>
                                </h6>
                                <p class="text-muted font-12">Anulados</p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 row">
                <div class="card-body">
                    <h5 class="mt-0 header-title"><b>Tipo Gestión SAC</b></h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Coins"></i>
                        <div class="content">
                            <center>
                                <h6 class="mb-0">
                                    <b><span id="atc-sales" name="atc-sales" class="atc-sales"
                                            style="font-size:15px;">0</span></b>
                                </h6>
                                <p class="text-muted font-12">Ventas</p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Billing"></i>
                        <div class="content">
                            <center>
                                <h6 class="mb-0">
                                    <b><span id="atc-invoices" name="atc-invoices" class="atc-invoices"
                                            style="font-size:15px;">0</span></b>
                                </h6>
                                <p class="text-muted font-12">Cobranza</p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Gears"></i>
                        <div class="content">
                            <center>
                                <h6 class="mb-0">
                                    <div id="atc-supports" name="atc-supports" class="atc-supports" style="font-size:15px;">
                                        <b>0</b>
                                    </div>
                                </h6>
                                <p class="text-muted font-12">Soporte</p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Network"></i>
                        <div class="content">
                            <center>
                                <h6 class="mb-0">
                                    <div id="atc-internal" name="atc-internal" class="atc-internal" style="font-size:15px;">
                                        <b>0</b>
                                    </div>
                                </h6>
                                <p class="text-muted font-12">Canales</p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        @can('atcs.create')
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <center>
                                    <div class="btn-group btn-sm" align="center">
                                        <button type="button" class="btn btn-sm btn-dark" style="color:white;">Gestión</button>
                                        <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-toggle="dropdown"
                                            style="color:white;"></button>
                                        <ul class="dropdown-menu" role="menu">
                                            @can('atcs.create')
                                                <li><a class="btn btn-sm  btn-default filter" style=" color: #47404f;"
                                                        href="{{ route('atcs.create') }}">Crear Ticket</a></li>
                                            @endcan
                                            <li><a id="create" class="btn btn-sm  btn-default filter">Generados</a></li>
                                            <li><a id="pending" class="btn btn-sm  btn-default filter">En Proceso</a></li>
                                            <li><a id="finish" class="btn btn-sm btn-default filter">Procesados</a></li>
                                            <li><a id="canceled" class="btn btn-sm  btn-default filter">Anulados</a></li>
                                            <li><a id="all" class="btn btn-sm  btn-default filter">Todos</a></li>
                                        </ul>
                                    </div>
                                </center>
                            @endcan
                            <br>
                        </div>

                        <div class="col-md-12">
                            <div id="atcs" style="display:block;" class="box-body table-responsive">
                                <table id="atcs-table" class="table table-striped table-bordered" cellspacing="0"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                <center>Acción</center>
                                            </th>
                                            <th>
                                                <center>No. Gestion</center>
                                            </th>
                                            <th>
                                                <center>Creado</center>
                                            </th>
                                            <th>
                                                <center>RIF</center>
                                            </th>
                                            <th>
                                                <center>Comercio / Usuario</center>
                                            </th>
                                            <th>
                                                <center>Canal Solicitud</center>
                                            </th>
                                            <th>
                                                <center>Tipo Operación</center>
                                            </th>
                                            <th>
                                                <center>Status</center>
                                            </th>
                                            <th>
                                                <center>Creado Por</center>
                                            </th>
                                            <th>
                                                <center>Actualizado</center>
                                            </th>
                                            <th>
                                                <center>Actualizado Por</center>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
    <!-- Content-->
@endsection

@include('supports::atcs.edit')
@include('supports::atcs.delete')
@include('supports::atcs.management')
@include('supports::atcs.change')
@include('supports::atcs.show')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    <script src="/assets/js/select2.min.js"></script>
    <script src="{{ asset('/assets/js/vendor/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>
    @toastr_js
    @toastr_render

    <script type="text/javascript">
        $.get('/atcs/totalStatus', function(data) {
            var total_ticket = 0;
            $.each(data, function(index, subAtcObj) {
                $("#atc-" + subAtcObj.atc_status).empty();
                $("#atc-" + subAtcObj.atc_status).append(subAtcObj.total);
                if (subAtcObj.atc_status == 'G' || subAtcObj.atc_status == 'P' || subAtcObj.atc_status ==
                    'F' || subAtcObj.atc_status == 'X') {
                    total_ticket = total_ticket + subAtcObj.total;
                }
            });
            $("#atc-total").empty();
            $("#atc-total").append(total_ticket);
        });

        $(document).ready(function() {
            $('#atcs').show();
            atcs('', '');
        });

        var atcs = function(status, managementtypes) {
            table = $('#atcs-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 50,
                ajax: "/atcs/datatable?status=" + status + "&slug=" + managementtypes,
                columns: [{
                        data: "actions",
                        "className": "text-center"
                    },
                    {
                        data: "id",
                        "className": "text-center"
                    },
                    {
                        data: "created",
                        "className": "text-center"
                    },
                    {
                        data: "rif",
                        "className": "text-center"
                    },
                    {
                        data: "name",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "channel",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "managementtype",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "status",
                        "className": "text-center"
                    },
                    {
                        data: "created_name",
                        "className": "text-center"
                    },
                    {
                        data: "updated",
                        "className": "text-center"
                    },
                    {
                        data: "updated_name",
                        "className": "text-center"
                    }
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [],
                "order": [
                    [2, "desc"]
                ]
            });
        }
        /****************************************************************************/
        $('#create').on('click', function() {
            table.destroy();
            atcs('G', '');
        });
        /****************************************************************************/
        $('#pending').on('click', function() {
            table.destroy();
            atcs('P', '');
        });
        /****************************************************************************/
        $('#finish').on('click', function() {
            table.destroy();
            atcs('F', '');
        });
        /****************************************************************************/
        $('#canceled').on('click', function() {
            table.destroy();
            atcs('X', '');
        });
        /****************************************************************************/
        $('#all').on('click', function() {
            table.destroy();
            atcs('', '');
        });
        /****************************************************************************/
        $.get('/channels/select', function(data) {
            $('#channel_id').empty();
            $('#channel_id').append("<option value=''>Seleccione Canal ATC...</option>");
            $.each(data, function(index, subChannelObj) {
                $('#channel_id').append("<option value='" + subChannelObj.id + "'>" + subChannelObj
                    .description + "</option>");
            });
            $("#channel_id option[value=" + {{ old('channel_id') }} + "]").attr("selected", true);
        });
        /**************************************************************************/
        $.get('/managementtypes/select', function(data) {
            $('#managementtype_id').empty();
            $('#managementtype_id').append("<option value=''>Seleccione Tipo Operación ATC...</option>");
            $.each(data, function(index, subManagementtypeObj) {
                $('#managementtype_id').append("<option value='" + subManagementtypeObj.id + "'>" +
                    subManagementtypeObj.description + "</option>");
            });
            $("#managementtype_id option[value=" + {{ old('managementtype_id') }} + "]").attr("selected", true);
        });
        /**************************************************************************/
        $('#managementtype_id').change(function(e) {
            managementtype_id = e.target.value;

            if (managementtype_id != '') {

                $.get('/mtypeitems/select?managementtype_id=' + managementtype_id, function(data) {
                    $('.mtypeitem_id').empty();
                    $('.mtypeitem_id').append(
                        "<option value=''>Seleccione Item Tipo Gestión ATC...</option>");
                    $.each(data, function(index, subMtypeitemObj) {
                        $('.mtypeitem_id').append("<option value='" + subMtypeitemObj.id + "'>" +
                            subMtypeitemObj.description + "</option>");
                    });
                });

            } else {
                $('.mtypeitem_id').empty();
                $('.mtypeitem_id').attr('readonly', 'readonly');
            }
        });
    </script>
    @include('supports::atcs.js')
@endsection
